<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\FootballPitch;
use App\Models\Order;
use App\Models\PeakHour;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stringable;
use Termwind\Components\Dd;

class OrderController extends Controller
{
    public function showAll(Request $request)
    {
        $arrInTime = [
            getTimeLaravel($request->start),
            getTimeLaravel($request->end),
        ];
        $orders = Order::query()->with('footballPitch')->whereBetween('start_at', $arrInTime)->get(
            [
                'id',
                'football_pitch_id',
                'name',
                'end_at',
                'start_at',
                'status',
            ]
        );
        $arr = [];
        $bg_color = [
            'wait' => '',
            'finish' => '#198754',
            'cancel' => '#dc3545',
            'running' => '#8fdf82'
        ];
        foreach ($orders as $order) {
            $color = '';
            $color = match($order->status) {
                OrderStatusEnum::Wait => $bg_color['wait'],
                OrderStatusEnum::Finish => $bg_color['running'],
                OrderStatusEnum::Cancel => $bg_color['cancel'],
                OrderStatusEnum::Paid => $bg_color['finish'],
                default => $color,
            };
            $arr[] = [
                'id' => $order->id,
                'title' => $order->footballPitch->name . ' : ' . $order->name,
                'start' => $order->start_at,
                'end' => $order->end_at,
                'backgroundColor' => $color,
                'extendedProps' => [
                    'football_pitch_id' => $order->footballPitch->id,
                ]
            ];
        }
        return response()->json($arr);
    }
    public function index()
    {
        $order = Order::query()->with('footballPitch')->get();
        return response()->json([
            'data' => $order,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //kiểm tra đầu vào
        $validated = $request->validate([
            'start_at' => 'required',
            'end_at' => 'required',
            'football_pitch_id' => 'required|exists:football_pitches,id',
        ]);
        //lấy thời gian bắt đầu và kết thúc của ngày hôm nay
        $end_of_day = (new Carbon('now'))->endOfDay();
        $start_of_day = (new Carbon('now'))->startOfDay();
        $arrInTime = [
            getTimeLaravel($start_of_day),
            getTimeLaravel($end_of_day),
        ];
        //tìm những sân đang được đặt trong hôm nay
        $orders = Order::query()->where('football_pitch_id', $validated['football_pitch_id'])
            ->whereBetween('start_at', $arrInTime)->get(['start_at', 'end_at']);
        //nếu sân yêu cầu đã được đặt trong thời gian đó rồi thì trả về lỗi
        foreach ($orders as $item) {
            if (isOrderInTime($validated['start_at'], $validated['end_at'], $item->start_at, $item->end_at)) {
                return response()->json([
                    'message' => 'Thời gian đã tồn tại trong hệ thống',
                    'status' => 'error'
                ], Response::HTTP_BAD_REQUEST);
            }
        }
        //tìm xem sân đang yêu cầu có đang liên kết với sân nào không, có thì trả về lỗi
        $football_pitch = FootballPitch::find($validated['football_pitch_id']);
        if ($football_pitch->from_football_pitch_id && $football_pitch->to_football_pitch_id) {
            $order_with_football_pitch_links = Order::query()->where('football_pitch_id', $football_pitch->from_football_pitch_id)
                ->orWhere('football_pitch_id', $football_pitch->to_football_pitch_id)
                ->whereBetween('start_at', $arrInTime)->get(['start_at', 'end_at']);
            foreach ($order_with_football_pitch_links as $item) {
                if (isOrderInTime($validated['start_at'], $validated['end_at'], $item->start_at, $item->end_at)) {
                    return response()->json([
                        'message' => 'Sân liên kết đang trong thời gian hoạt động',
                        'status' => 'error'
                    ], Response::HTTP_BAD_REQUEST);
                }
            }
        } else {
            $orders = Order::query()
                ->join('football_pitches', 'football_pitches.id', '=', 'orders.football_pitch_id')
                ->where('football_pitches.from_football_pitch_id', '=', $validated['football_pitch_id'])
                ->orWhere('football_pitches.to_football_pitch_id', '=', $validated['football_pitch_id'])
                ->get([
                    'start_at', 'end_at'
                ]);
            foreach ($orders as $item) {
                if (isOrderInTime($validated['start_at'], $validated['end_at'], $item->start_at, $item->end_at)) {
                    return response()->json([
                        'message' => 'Sân liên kết đang trong thời gian hoạt động',
                        'status' => 'error'
                    ], Response::HTTP_BAD_REQUEST);
                }
            }
        }
        //kiểm tra xem thời gian đó có phải lúc sân đang mở không
        $time_start = explode(' ', getTimeLaravel($validated['start_at']))[1];
        $time_end = explode(' ', getTimeLaravel($validated['end_at']))[1];
        if (!isOrderInTime(
            $time_start,
            $time_end,
            $football_pitch->time_start,
            $football_pitch->time_end
        )) {
            return response()->json([
                'message' => 'Thời gian bạn đặt sân chưa mở',
                'status' => 'error'
            ], Response::HTTP_BAD_REQUEST);
        }
        //nếu không có lỗi gì thì thêm yêu cầu mới vào
        $peak_hour = PeakHour::all()->firstOrFail();
        $total_price = getPriceOrder([
            'time_start' => $peak_hour->start_at,
            'time_end' => $peak_hour->end_at,
        ], [
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
        ], $football_pitch->price_per_hour, $football_pitch->price_per_peak_hour);

        $obj = Order::create([
            'start_at' => getTimeLaravel($validated['start_at']),
            'end_at' => getTimeLaravel($validated['end_at']),
            'user_id' => auth()->user()->id,
            'football_pitch_id' => $validated['football_pitch_id'],
            'total' => $total_price,
            'deposit' => $total_price * 0.4,
            'code' => strtoupper(Str::random(10)),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Yêu cầu đã được tạo hoàn tất',
            'data' => $obj,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::query()->find($id);
        if ($order) {
            switch ($request->get('type')) {
                case 'update_time': //update khi keo order (time)
                    $validated = $request->validate([
                        'start_at' => 'nullable',
                        'end_at' => 'nullable',
                    ]);
                    //lấy thời gian bắt đầu và kết thúc của ngày hôm nay
                    $end_of_day = (new Carbon('now'))->endOfDay();
                    $start_of_day = (new Carbon('now'))->startOfDay();
                    $arrInTime = [
                        getTimeLaravel($start_of_day),
                        getTimeLaravel($end_of_day),
                    ];
                    //tìm những sân đang được đặt trong hôm nay
                    $orders = Order::query()->where('football_pitch_id', $order->football_pitch_id)
                        ->where('id', '!=', $order->id)
                        ->whereBetween('start_at', $arrInTime)->get(['start_at', 'end_at']);
                    //nếu sân yêu cầu đã được đặt trong thời gian đó rồi thì trả về lỗi
                    foreach ($orders as $item) {
                        if (isOrderInTime($validated['start_at'], $validated['end_at'], $item->start_at, $item->end_at)) {
                            return response()->json([
                                'message' => 'Thời gian đã tồn tại trong hệ thống',
                                'status' => 'error'
                            ], Response::HTTP_BAD_REQUEST);
                        }
                    }
                    //tìm xem sân đang yêu cầu có đang liên kết với sân nào không, có thì trả về lỗi
                    $football_pitch = FootballPitch::find($order->football_pitch_id);
                    if ($football_pitch->from_football_pitch_id && $football_pitch->to_football_pitch_id) {
                        $order_with_football_pitch_links = Order::query()->where('football_pitch_id', $football_pitch->from_football_pitch_id)
                            ->orWhere('football_pitch_id', $football_pitch->to_football_pitch_id)
                            ->where('id', '!=', $order->id)
                            ->whereBetween('start_at', $arrInTime)->get(['start_at', 'end_at']);
                        foreach ($order_with_football_pitch_links as $item) {
                            if (isOrderInTime($validated['start_at'], $validated['end_at'], $item->start_at, $item->end_at)) {
                                return response()->json([
                                    'message' => 'Sân liên kết đang trong thời gian hoạt động',
                                    'status' => 'error'
                                ], Response::HTTP_BAD_REQUEST);
                            }
                        }
                    } else {
                        $orders = Order::query()
                            ->join('football_pitches', 'football_pitches.id', '=', 'orders.football_pitch_id')
                            ->where('orders.id', '!=', $order->id)
                            ->where('football_pitches.from_football_pitch_id', '=', $order->football_pitch_id)
                            ->orWhere('football_pitches.to_football_pitch_id', '=', $order->football_pitch_id)
                            ->get([
                                'start_at', 'end_at'
                            ]);
                        foreach ($orders as $item) {
                            if (isOrderInTime($validated['start_at'], $validated['end_at'], $item->start_at, $item->end_at)) {
                                return response()->json([
                                    'message' => 'Sân liên kết đang trong thời gian hoạt động',
                                    'status' => 'error'
                                ], Response::HTTP_BAD_REQUEST);
                            }
                        }
                    }
                    //kiểm tra xem thời gian đó có phải lúc sân đang mở không
                    $time_start = explode(' ', getTimeLaravel($validated['start_at']))[1];
                    $time_end = explode(' ', getTimeLaravel($validated['end_at']))[1];
                    if (!isOrderInTime(
                        $time_start,
                        $time_end,
                        $football_pitch->time_start,
                        $football_pitch->time_end
                    )) {
                        return response()->json([
                            'message' => 'Thời gian bạn đặt sân chưa mở',
                            'status' => 'error'
                        ], Response::HTTP_BAD_REQUEST);
                    }

                    //cap nhat
                    $arr = [];
                    if ($request->has('start_at')) {
                        $arr['start_at'] = getTimeLaravel($validated['start_at']);
                    }
                    if ($request->has('end_at')) {
                        $arr['end_at'] = getTimeLaravel($validated['end_at']);
                    }
                    $order->update($arr);
                    $football_pitch = FootballPitch::find($order->football_pitch_id);
                    $peak_hour = PeakHour::all()->firstOrFail();
                    $total_price = getPriceOrder([
                        'time_start' => $peak_hour->start_at,
                        'time_end' => $peak_hour->end_at,
                    ], [
                        'start_at' => $order->start_at,
                        'end_at' => $order->end_at,
                    ], $football_pitch->price_per_hour, $football_pitch->price_per_peak_hour);
                    $order->update(['total' => $total_price]);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Yêu cầu đã được cập nhật hoàn tất',
                    ]);
                    break;
                case 'update_info': //update khi click vao order
                    $validated = $request->validate([
                        'name' => 'required|string',
                        'phone' => 'required|numeric',
                        'email' => 'nullable|email',
                        'deposit' => 'required|numeric',
                        'note' => 'nullable|string',
                    ]);
                    $validated['status'] = OrderStatusEnum::Finish;
                    $order->update($validated);
                    $arr = [
                        'id' => $order->id,
                        'title' => $order->footballPitch->name . ' : ' . $order->name,
                        'start' => $order->start_at,
                        'end' => $order->end_at,
                        'extendedProps' => [
                            'football_pitch_id' => $order->footballPitch->id,
                        ]
                    ];
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Yêu cầu đã được cập nhật hoàn tất',
                        'data' => $arr
                    ]);
                    //return redirect()->back()->with('message', 'Yêu cầu đã được cập nhật hoàn tất');
                    break;
            }
        }
        return response()->json([
            'message' => 'Không thể tìm thấy yêu cầu'
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function paid(string $id)
    {
        $obj = Order::find($id);
        $obj->status = OrderStatusEnum::Paid;
        $obj->save();
        return redirect()->back()->with('message', 'Thanh toán thành công');
    }
}

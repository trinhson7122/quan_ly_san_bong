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

class OrderController extends Controller
{
    public function showAll(Request $request)
    {
        $arrInTime = [
            getTimeLaravel($request->start),
            getTimeLaravel($request->end),
        ];
        $orders = Order::query()->whereBetween('start_at', $arrInTime)->get();
        $arr = [];
        foreach ($orders as $order) {
            $arr[] = [
                'id' => $order->id,
                'title' => $order->footballPitch->name . ' - ' . $order->name,
                'start' => $order->start_at,
                'end' => $order->end_at,
                'extendedProps' => [
                    'football_pitch_id' => $order->footballPitch->id,
                ]
            ];
        }
        return response()->json($arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_at' => 'required',
            'end_at' => 'required',
            'football_pitch_id' => 'required|exists:football_pitches,id',
        ]);
        $end_of_day = (new Carbon('now'))->endOfDay();
        $start_of_day = (new Carbon('now'))->startOfDay();
        $arrInTime = [
            getTimeLaravel($start_of_day),
            getTimeLaravel($end_of_day),
        ];
        //
        $orders = Order::query()->where('football_pitch_id', $validated['football_pitch_id'])
            ->whereBetween('start_at', $arrInTime)->get(['start_at', 'end_at']);
        foreach ($orders as $item) {
            if (isOrderInTime($validated['start_at'], $validated['end_at'], $item->start_at, $item->end_at)) {
                return response()->json([
                    'message' => 'Thời gian đã tồn tại trong hệ thống',
                    'status' => 'error'
                ], Response::HTTP_BAD_REQUEST);
            }
        }
        //
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
        }
        //
        $football_pitch = FootballPitch::find($validated['football_pitch_id']);
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
                    ]);
                    $validated[] = ['status' => OrderStatusEnum::Finish];
                    $order->update($validated);
                    return redirect()->back()->with('message', 'Yêu cầu đã được cập nhật hoàn tất');
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
}

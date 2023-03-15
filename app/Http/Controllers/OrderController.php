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
use Illuminate\Support\Str;
use Stringable;

class OrderController extends Controller
{
    public function showAll()
    {
        $orders = Order::all();
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

        $football_pitch = FootballPitch::find($validated['football_pitch_id']);
        $peak_hour = PeakHour::all()->firstOrFail();
        $total = getPriceOrder([
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
            'total' => $total,
            'deposit' => $total * 0.4,
            'code' => strtoupper(Str::random(10)),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
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
        $order = Order::find($id);
        if ($order) {
            if ($request->has('type')) {
                $validated = $request->validate([
                    'name' => 'required|string',
                    'phone' => 'required|numeric',
                    'email' => 'nullable|email',
                    'deposit' => 'required|numeric',
                ]);
                $arr = [
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'deposit' => $validated['deposit'],
                    'status' => OrderStatusEnum::Finish,
                ];
                if ($request->has('email')) {
                    $arr['email'] = $validated['email'];
                }
                $order->update($arr);

                return redirect()->back()->with('message', 'Yêu cầu đã được cập nhật hoàn tất');

            } else {
                $validated = $request->validate([
                    'start_at' => 'nullable',
                    'end_at' => 'nullable',
                    'title' => 'nullable',
                ]);
                $arr = [];
                if ($request->has('start_at')) {
                    $arr['start_at'] = getTimeLaravel($validated['start_at']);
                }
                if ($request->has('end_at')) {
                    $arr['end_at'] = getTimeLaravel($validated['end_at']);
                }
                if ($request->has('title')) {
                    $arr['title'] = $validated['title'];
                }
                $arr['status'] = OrderStatusEnum::Finish;
                $order->update($arr);

                return response()->json([
                    'message' => 'Yêu cầu đã được cập nhật hoàn tất'
                ]);
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

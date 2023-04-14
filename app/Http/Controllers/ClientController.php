<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\BankInformation;
use App\Models\FootballPitch;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $title = "Trang chủ";
        $footballPitches = FootballPitch::query()->with('pitchType')->with('images')->get();
        return view('client.home.index', [
            'title' => $title,
            'footballPitches' => $footballPitches,
        ]);
    }
    //chi tiet san bong
    public function footballPitchDetail(string $id)
    {
        $title = "Chi tiết sân bóng";
        $footballPitch = FootballPitch::query()->with('pitchType')->with('images')->with('orders')->find($id);
        return view('client.home.footballPitchDetail', [
            'title' => $title,
            'footballPitch' => $footballPitch,
        ]);
    }
    //checkout
    public function checkout(string $id)
    {
        $title = "Thông tin đặt sân";
        $order = Order::query()->with('footballPitch')->where('status', OrderStatusEnum::Wait)->find($id);
        if (!$order) {
            return abort(404);
        }
        $bankInfo = BankInformation::query()->where('isShow', 1)->get();
        return view('client.home.checkout', [
            'title' => $title,
            'order' => $order,
            'bankInfo' => $bankInfo,
        ]);
    }
}

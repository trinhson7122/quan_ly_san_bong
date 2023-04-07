<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\FootballPitch;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $title = "Trang chủ";
        // $topFootballPitches = DB::table('orders')
        //     ->where('status', OrderStatusEnum::Finish)
        //     ->groupBy('football_pitch_id')
        //     ->selectRaw("football_pitch_id, count(football_pitch_id) as test")->get();
            //->get(['football_pitch_id']);
        // $topFootballPitches = Order::query()->where('status', OrderStatusEnum::Finish)
        //     ->where('status', OrderStatusEnum::Finish)
        //     ->orderBy('aggregate', 'desc')
        //     ->groupBy('football_pitch_id')
        //     ->count('id');
            //->get(['aggregate', 'football_pitch_id']);
        //dd($topFootballPitches);
        $footballPitches = FootballPitch::query()->with('pitchType')->with('images')->get();
        //dd($footballPitches->find(3)->images->count());
        return view('client.home.index', [
            'title' => $title,
            'footballPitches' => $footballPitches,
            //'topFootballPitches' => $topFootballPitches,
        ]);
    }
}

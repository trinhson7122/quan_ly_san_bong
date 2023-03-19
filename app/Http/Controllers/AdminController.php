<?php

namespace App\Http\Controllers;

use App\Models\FootballPitch;
use App\Models\FootballPitchDetail;
use App\Models\PitchType;

class AdminController extends Controller
{
    //Trang chu
    public function dashboard()
    {
        $title = 'Dashboard';
        return view('admin.dashboard.index', [
            'title' => $title,
        ]);
    }
    //The loai san bong
    public function pitchType()
    {
        $title = 'Pitch Type';
        $pitchTypes = PitchType::query()->orderByDesc('id')->get();
        return view('admin.pitch_type.index', [
            'title' => $title,
            'pitchTypes' => $pitchTypes,
        ]);
    }
    //San bong
    public function footballPitch()
    {
        $title = 'Football Pitch';
        $footballPitches = FootballPitch::query()->orderByDesc('id')->with('pitchType')->get();
        $pitchTypes = PitchType::all();
        return view('admin.football_pitch.index', [
            'title' => $title,
            'footballPitches' => $footballPitches,
            'pitchTypes' => $pitchTypes,
        ]);
    }
    //Chi tiet san bong
    public function footballPitchDetail(string $id)
    {
        $title = 'Football Pitch Detail';
        $footballPitchDetails = FootballPitchDetail::query()->where('football_pitch_id', $id)->get();
        $footballPitch = FootballPitch::query()->with('pitchType')
            ->with('toFootballPitch')
            ->with('fromFootballPitch')->find($id);
        $pitchTypes = PitchType::all();
        $footballPitches = FootballPitch::query()->orderByDesc('id')->get([
            'id',
            'name',
            'to_football_pitch_id',
            'from_football_pitch_id',
        ]);
        return view('admin.football_pitch.detail', [
            'title' => $title,
            'footballPitchDetails' => $footballPitchDetails,
            'footballPitch' => $footballPitch,
            'pitchTypes' => $pitchTypes,
            'footballPitches' => $footballPitches,
        ]);
    }
    //yeu cau
    public function order()
    {
        $title = 'Order';
        $footballPitches = FootballPitch::query()->where('is_maintenance', 0)->with('pitchType')->get([
            'id',
            'name',
            'pitch_type_id',
        ]);
        return view('admin.order.index', [
            'title' => $title,
            'footballPitches' => $footballPitches,
        ]);
    }
}

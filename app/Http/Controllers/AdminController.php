<?php

namespace App\Http\Controllers;

use App\Models\FootballPitch;
use App\Models\FootballPitchDetail;
use App\Models\PitchType;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        return view('admin.dashboard.index', [
            'title' => $title,
        ]);
    }

    public function pitchType()
    {
        $title = 'Pitch Type';
        $pitchTypes = PitchType::query()->orderByDesc('id')->get();
        return view('admin.pitch_type.index', [
            'title' => $title,
            'pitchTypes' => $pitchTypes,
        ]);
    }

    public function footballPitch()
    {
        $title = 'Football Pitch';
        $footballPitches = FootballPitch::query()->orderByDesc('id')->get();
        $pitchTypes = PitchType::all();
        $arr = [];
        foreach($footballPitches as $item){
            array_push($arr, [
                'id' => $item->id,
                'name' => $item->name,
                'pitch_type' => $item->pitchType->quantity,
                'time_start' => timeForHumans($item->time_start),
                'time_end' => timeForHumans($item->time_end),
                'price_per_hour' => printMoney($item->price_per_hour),
                'price_per_peak_hour' => printMoney($item->price_per_peak_hour),
                'is_maintenance' => $item->is_maintenance,
            ]);
        }
        return view('admin.football_pitch.index', [
            'title' => $title,
            'footballPitches' => $arr,
            'pitchTypes' => $pitchTypes,
        ]);
    }

    public function footballPitchDetail(string $id)
    {
        $title = 'Football Pitch Detail';
        $footballPitchDetails = FootballPitchDetail::query()->where('football_pitch_id', $id)->get();
        $footballPitch = FootballPitch::query()->find($id);
        $i = 0;
        $arr_fpd = [];
        $arr_fp = [];
        foreach($footballPitchDetails as $item){
            array_push($arr_fpd, [
                'id' => $item->id,
                'image' => $item->image,
                'created_at' => $item->created_at->diffForHumans(),
                'index' => $i,
            ]);
            $i++;
        }
        $item = $footballPitch;
        array_push($arr_fp, [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'pitch_type' => $item->pitchType->quantity,
            'time_start' => timeForHumans($item->time_start),
            'time_end' => timeForHumans($item->time_end),
            'price_per_hour' => printMoney($item->price_per_hour),
            'price_per_peak_hour' => printMoney($item->price_per_peak_hour),
            'created_at' => $item->created_at->diffForHumans(),
            'is_maintenance' => $item->is_maintenance,
            'link_football_pitch' => $item->from_football_pitch_id ? ($item->fromFootballPitch->name . ' - ' . $item->toFootballPitch->name) : '',
        ]);
        return view('admin.football_pitch.detail', [
            'title' => $title,
            'footballPitchDetails' => $arr_fpd,
            'footballPitch' => $arr_fp[0],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

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
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFootballPitchRequest;
use App\Models\FootballPitch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FootballPitchController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFootballPitchRequest $request): RedirectResponse
    {
        FootballPitch::create($request->validated());
        return to_route('admin.footballPitch')->with('message', 'Thêm sân bóng thành công');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFootballPitchRequest $request, string $id): RedirectResponse
    {
        $obj = FootballPitch::find($id);
        $obj->update($request->validated());
        return redirect()->back()->with('message', 'Cập nhật sân bóng thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $obj = FootballPitch::find($id);
        $obj->delete();
        return to_route('admin.footballPitch')->with('message', 'Xóa sân bóng thành công');
    }

    public function maintenance(string $id, Request $request)
    {
        $obj = FootballPitch::find($id);
        $request->validate([
            'is_maintenance' => 'required|in:0,1',
        ]);
        $obj->is_maintenance = $request->is_maintenance;
        $obj->save();
        return to_route('admin.footballPitch')->with('message', 'Cập nhật tình trạng sân bóng thành công');
    }
}

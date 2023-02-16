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
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return Response(FootballPitch::find($id));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $obj = FootballPitch::find($id);
        $obj->update();
        return to_route('admin.footballPitch')->with('message', 'Cập nhật sân bóng thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        return to_route('admin.footballPitch')->with('message', 'Xóa sân bóng thành công');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Http\Requests\Admin\UpdateRoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('sort_order')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function store(StoreRoomRequest $request)
    {
        Room::create([
            ...$request->validated(),
            'amenities'   => $request->amenitiesArray(),
            'is_active'   => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
        ]);
        return back()->with('success', 'Room added successfully.');
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update([
            ...$request->validated(),
            'amenities'   => $request->amenitiesArray(),
            'is_active'   => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
        ]);
        return back()->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return back()->with('success', 'Room deleted.');
    }
}

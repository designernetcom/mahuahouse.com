<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::orderBy('sort_order')->get();
        return view('admin.stats.index', compact('stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['value' => 'required|string', 'label' => 'required|string', 'icon' => 'nullable|string|max:100', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        Stat::create($data);
        return back()->with('success', 'Stat added successfully.');
    }

    public function update(Request $request, Stat $stat)
    {
        $data = $request->validate(['value' => 'required|string', 'label' => 'required|string', 'icon' => 'nullable|string|max:100', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        $stat->update($data);
        return back()->with('success', 'Stat updated successfully.');
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();
        return back()->with('success', 'Stat deleted.');
    }
}

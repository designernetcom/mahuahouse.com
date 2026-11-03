<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChoose;
use Illuminate\Http\Request;

class WhyChooseController extends Controller
{
    public function index()
    {
        $items = WhyChoose::orderBy('sort_order')->get();
        return view('admin.why-choose.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'description' => 'nullable|string', 'icon' => 'nullable|string|max:100', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        WhyChoose::create($data);
        return back()->with('success', 'Item added successfully.');
    }

    public function update(Request $request, WhyChoose $whyChoose)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'description' => 'nullable|string', 'icon' => 'nullable|string|max:100', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        $whyChoose->update($data);
        return back()->with('success', 'Item updated successfully.');
    }

    public function destroy(WhyChoose $whyChoose)
    {
        $whyChoose->delete();
        return back()->with('success', 'Item deleted.');
    }
}

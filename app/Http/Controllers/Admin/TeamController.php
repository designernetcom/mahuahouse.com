<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->get();
        return view('admin.team.index', compact('members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'role' => 'nullable|string|max:255', 'bio' => 'nullable|string', 'image_url' => 'nullable|string', 'social_facebook' => 'nullable|string', 'social_instagram' => 'nullable|string', 'social_twitter' => 'nullable|string', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        TeamMember::create($data);
        return back()->with('success', 'Team member added successfully.');
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'role' => 'nullable|string|max:255', 'bio' => 'nullable|string', 'image_url' => 'nullable|string', 'social_facebook' => 'nullable|string', 'social_instagram' => 'nullable|string', 'social_twitter' => 'nullable|string', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        $teamMember->update($data);
        return back()->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return back()->with('success', 'Team member deleted.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $incoming = $request->input('settings', []);
        foreach ($incoming as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'label' => ucwords(str_replace('_', ' ', $key)), 'group_name' => 'General']
            );
        }
        return back()->with('success', 'Settings saved successfully.');
    }
}

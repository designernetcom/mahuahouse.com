<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contacts = ContactInfo::orderBy('sort_order')->get();
        return view('admin.contact-info.index', compact('contacts'));
    }

    public function update(Request $request)
    {
        $items = $request->input('contacts', []);
        foreach ($items as $key => $data) {
            ContactInfo::where('key', $key)->update(['value' => $data['value'] ?? '']);
        }
        return back()->with('success', 'Contact information updated successfully.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key'        => 'required|string|unique:contact_infos,key',
            'label'      => 'nullable|string',
            'value'      => 'nullable|string',
            'icon'       => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        ContactInfo::create($data);
        return back()->with('success', 'Contact info added.');
    }

    public function singleUpdate(Request $request, ContactInfo $contactInfo)
    {
        $data = $request->validate([
            'key'        => 'required|string|unique:contact_infos,key,' . $contactInfo->id,
            'label'      => 'nullable|string',
            'value'      => 'nullable|string',
            'icon'       => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $contactInfo->update($data);
        return back()->with('success', 'Contact info updated.');
    }

    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();
        return back()->with('success', 'Contact info deleted.');
    }
}

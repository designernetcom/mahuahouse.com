<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $status   = $request->query('status', '');
        $query    = Inquiry::latest();
        if ($status) $query->where('status', $status);
        $inquiries = $query->paginate(20);

        // Mark as read when viewed
        if (!$status || $status === 'new') {
            Inquiry::where('status', 'new')->update(['status' => 'read']);
        }

        $counts = [
            'all'     => Inquiry::count(),
            'new'     => Inquiry::where('status', 'new')->count(),
            'read'    => Inquiry::where('status', 'read')->count(),
            'replied' => Inquiry::where('status', 'replied')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts', 'status'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $inquiry->update(['status' => $request->status]);
        return back()->with('success', 'Inquiry status updated.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return back()->with('success', 'Inquiry deleted.');
    }
}

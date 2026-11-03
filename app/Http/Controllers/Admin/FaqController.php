<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['question' => 'required|string', 'answer' => 'required|string', 'category' => 'nullable|string|max:100', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        Faq::create($data);
        return back()->with('success', 'FAQ added successfully.');
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate(['question' => 'required|string', 'answer' => 'required|string', 'category' => 'nullable|string|max:100', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        $faq->update($data);
        return back()->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::orderBy('sort_order')->get();
        return view('admin.offers.index', compact('offers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'badge_text'     => 'nullable|string|max:100',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'duration'       => 'nullable|string|max:100',
            'inclusions'     => 'nullable|string',
            'image_url'      => 'nullable|string',
            'valid_until'    => 'nullable|date',
            'sort_order'     => 'nullable|integer',
        ]);
        $data['inclusions']  = $this->parseInclusions($request->inclusions);
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        Offer::create($data);
        return back()->with('success', 'Offer added successfully.');
    }

    public function update(Request $request, Offer $offer)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'badge_text'     => 'nullable|string|max:100',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'duration'       => 'nullable|string|max:100',
            'inclusions'     => 'nullable|string',
            'image_url'      => 'nullable|string',
            'valid_until'    => 'nullable|date',
            'sort_order'     => 'nullable|integer',
        ]);
        $data['inclusions']  = $this->parseInclusions($request->inclusions);
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $offer->update($data);
        return back()->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return back()->with('success', 'Offer deleted.');
    }

    private function parseInclusions(?string $raw): array
    {
        if (!$raw) return [];
        return array_values(array_filter(array_map('trim', explode("\n", $raw))));
    }
}

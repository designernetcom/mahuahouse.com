<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:10240']);
        $path = $request->file('image')->store('uploads', 'public');
        return response()->json(['url' => '/storage/' . $path]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::latest()->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'excerpt'   => 'nullable|string',
            'content'   => 'nullable|string',
            'image_url' => 'nullable|string',
            'author'    => 'nullable|string|max:255',
            'category'  => 'nullable|string|max:100',
            'tags'      => 'nullable|string',
            'read_time' => 'nullable|integer|min:1',
        ]);
        $data['slug']         = Str::slug($data['title']);
        $data['tags']         = array_values(array_filter(array_map('trim', explode(',', $request->tags ?? ''))));
        $data['is_published'] = $request->has('is_published');
        $data['is_featured']  = $request->has('is_featured');
        $data['published_at'] = $data['is_published'] ? now() : null;
        BlogPost::create($data);
        return back()->with('success', 'Blog post added successfully.');
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'excerpt'   => 'nullable|string',
            'content'   => 'nullable|string',
            'image_url' => 'nullable|string',
            'author'    => 'nullable|string|max:255',
            'category'  => 'nullable|string|max:100',
            'tags'      => 'nullable|string',
            'read_time' => 'nullable|integer|min:1',
        ]);
        $data['tags']         = array_values(array_filter(array_map('trim', explode(',', $request->tags ?? ''))));
        $data['is_published'] = $request->has('is_published');
        $data['is_featured']  = $request->has('is_featured');
        if ($data['is_published'] && !$blogPost->published_at) {
            $data['published_at'] = now();
        } elseif (!$data['is_published']) {
            $data['published_at'] = null;
        }
        $blogPost->update($data);
        return back()->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();
        return back()->with('success', 'Blog post deleted.');
    }
}

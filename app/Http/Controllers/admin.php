<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// This is a controller for handling admin-related actions
class admin extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.index', compact('posts'));
    }
    public function create()
    {
        return view('admin.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published'
        ]);

        $validated['user_id'] = auth()->id();
        Post::create($validated);

        return redirect()->route('admin.index')->with('success', 'Post created successfully');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published'
        ]);

        $post->update($validated);

        return redirect()->route('admin.index')->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.index')->with('success', 'Post deleted successfully');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.show', compact('post'));
    }
}
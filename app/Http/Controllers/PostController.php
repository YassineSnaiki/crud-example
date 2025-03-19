<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        return response()->json(Post::all(),200);
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $post = Post::create($data);
        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
        ],201);
    }


    public function show(Post $post)
    {
        return response()->json($post,200);
    }



    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => '',
            'content' => '',
        ]);
        $post->update($data);
        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post,
        ],200);
    }

    
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully',
        ],200);
    }
}

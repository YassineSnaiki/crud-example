<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="Endpoints for managing posts"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     required={"title", "content"},
 *     @OA\Property(property="id", type="integer", description="ID of the post", example=1),
 *     @OA\Property(property="title", type="string", description="Title of the post", example="Post Title"),
 *     @OA\Property(property="content", type="string", description="Content of the post", example="Content of the post")
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/posts",
     *     summary="List all posts",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="All posts",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/Post")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Post::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Post object that needs to be added",
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string", example="Toyota"),
     *             @OA\Property(property="content", type="string", example="Corolla description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);
        $post = Post::create($data);
        return response()->json([
            'message' => 'Post created successfully',
            'post'    => $post,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/posts/{id}",
     *     summary="Get a specific post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    /**
     * @OA\Put(
     *     path="/posts/{id}",
     *     summary="Update a post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Post object with updated information",
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string", example="Updated Toyota"),
     *             @OA\Property(property="content", type="string", example="Updated Corolla description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'   => '',
            'content' => '',
        ]);
        $post->update($data);
        return response()->json([
            'message' => 'Post updated successfully',
            'post'    => $post,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/posts/{id}",
     *     summary="Delete a post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Post deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully',
        ], 200);
    }
}

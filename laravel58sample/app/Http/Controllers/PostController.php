<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\PostsCollectionResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Exception\UnsupportedOperationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PostsCollectionResource
     */
    public function index()
    {
        $postsCollection = Post::limit(10)->get();
        $resourceCollection = new PostsCollectionResource($postsCollection);
        return response()->json($resourceCollection, Response::HTTP_OK);

    }

    /**
     * Store a newly created resource in storage.
     * Header: POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resource = $request->getContent();
        $postData = \json_decode($resource, true);
        $postData['user_id'] = $request->user()->id;
        $newPost = Post::create($postData);
        $postResource = new PostResource($newPost);
        return response()->json($postResource, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     * Header: GET
     *
     * @param  Post $post
     * @return Post
     */
    public function show(Post $post)
    {
        return response()->json($post, Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     * Header: PUT
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return Post
     */
    public function update(Request $request, Post $post)
    {
        $postData = $request->all();
        $post->update($postData);
        $postResource = new PostResource($post);
        return response()->json($postResource, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * Header: DELETE
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Post $post)
    {
        $post->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

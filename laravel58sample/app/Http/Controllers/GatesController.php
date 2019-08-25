<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class GatesController extends Controller
{
    /**
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function seePost(Post $post)
    {
        if (Gate::allows('see-post', $post)) {
            return response()->json($post);
        }
        if (Gate::denies('see-post', $post)) {
            return response(Response::HTTP_UNAUTHORIZED)
                ->json(['error' => "You can't see this resource."]);
        }
        throw new \Exception("Something went wrong");
    }
}

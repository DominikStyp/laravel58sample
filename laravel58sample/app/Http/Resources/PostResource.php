<?php

namespace App\Http\Resources;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Post $post */
        $post = $this->resource;
        /** @var Carbon $created */
        $created = $post->created_at ?? null;
        $updated = $post->updated_at ?? null;
        //dd($post->user());
        return [
            //'id' => $this->id,
            'title' => $post->title,
            'content' => $post->content,
            'created_at' => ($created) ? $created->format("Y-m-d H:i:s") : null,
            'updated_at' => $updated,
            'user_id' => $post->user->id
        ];
       // return parent::toArray($request);
    }
}

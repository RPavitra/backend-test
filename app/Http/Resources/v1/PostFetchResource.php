<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;
/** @mixin \App\Models\Post */
class PostFetchResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $comments = Http::get('https://jsonplaceholder.typicode.com/comments');
        return [
            'post_id' => $this->resource['id'],
            'post_title' => $this->resource['title'],
            'post_body' => $this->resource['body'],
            'total_number_of_comments' => count(collect($comments->json())->where('postId','=',$this->resource['id'])),
        ];
    }
}

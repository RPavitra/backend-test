<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Comment */
class CommentFetchResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource['id'],
            'post_id' => $this->resource['postId'],
            'name' => $this->resource['name'],
            'email' => $this->resource['email'],
            'body' => $this->resource['body'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

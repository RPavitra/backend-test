<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\PostFetchResource;
use Illuminate\Support\Facades\Http;
class PostController extends Controller
{

    /**
     * Gets list of posts with comment counts
     */
    public function index()
    {
        $posts = Http::get('https://jsonplaceholder.typicode.com/posts');
        $posts = collect(PostFetchResource::collection($posts->json()))->sortBy([
            ['total_number_of_comments','desc']
        ]);

        return $posts;
    }
}

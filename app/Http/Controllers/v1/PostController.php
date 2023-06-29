<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\PostResource;
use App\Http\Resources\v1\CommentFetchResource;
use App\Http\Resources\v1\PostFetchResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\throwException;
class PostController extends Controller
{

    /**
     * Gets list of posts with comment counts
     */
    public function index()
    {
        $posts = Post::withCount('comments as comments_count')->orderByDesc('comments_count')->get();
        return PostResource::collection($posts);
    }

    /**
     * Gets list of posts and comments from api
     */
    public function fetch()
    {
        $posts = Http::get('https://jsonplaceholder.typicode.com/posts');
        $comments = Http::get('https://jsonplaceholder.typicode.com/comments');

        if ($posts->successful() && $comments->successful()) {
            DB::beginTransaction();
            try {
                Post::upsert(PostFetchResource::collection($posts->json())->resolve(),['id']);
                Comment::upsert(CommentFetchResource::collection($comments->json())->resolve(),['id']);
                DB::commit();
            }
            catch (\Exception $exception){
                DB::rollBack();
                throwException($exception->getMessage());
            }
            return response()->json(["message" => "Data from api inserted successfully."],200);
        }
        else {
            return response()->json(["error" => "Failed to retrieve json api data."],400);
        }
    }
}

<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\v1\CommentFetchResource;
class SearchController extends Controller
{
    public function search($id,$search)
    {
        $search_columns = ['name','email','body']; // add column name into the array if required
        $search_string = trim($search);
        $comments = Http::get('https://jsonplaceholder.typicode.com/comments');
        $comments = collect(CommentFetchResource::collection($comments->json()))->where('post_id','=',$id)->filter(function ($comment) use($search_columns,$search_string){
            $exists = null;
            foreach ($search_columns as $search_column) {
                if (stripos($comment[$search_column],$search_string)) {
                    $exists = true;
                    break;
                }
            }
            return ($comment == $exists);
        });
        return $comments;
    }
}

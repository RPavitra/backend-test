<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\SearchRequest;
use App\Http\Resources\v1\CommentResource;
use App\Models\Comment;
class SearchController extends Controller
{
    /**
     * Filters comments based on available fields in comments table
     */
    public function store(SearchRequest $request,$id)
    {
        $search_columns = ['post_id','name','email','body']; // add column name into the array if required
        $search_string = trim($request->validated()['search']);
        $comments = Comment::wherePostId($id)->where(function ($q) use($search_columns,$search_string){
            foreach ($search_columns as $column){
                $q->orWhere($column,'LIKE',"%{$search_string}%");
            }
        })->paginate();

        return CommentResource::collection($comments);
    }
}

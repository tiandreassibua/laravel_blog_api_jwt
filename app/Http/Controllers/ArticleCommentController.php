<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleCommentController extends Controller
{
    public function store(Request $request, $article_id)
    {
        $validator = Validator::make(request()->all(), [
            "body" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $user = auth()->user();
        $comment = $user->articleComments()->create([
            "article_id" => $article_id,
            "body" => $request->body,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Comment created successfully",
            "data" => $comment,
        ], 201);
    }
    public function update(Request $request, $comment_id)
    {
    }
    public function destroy($comment_id)
    {
    }
}

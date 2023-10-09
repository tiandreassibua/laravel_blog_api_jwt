<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $articles = $user->articles()->latest()->get();

        return response()->json([
            "success" => true,
            "data" => $articles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "title" => "required|string",
            "body" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $user = auth()->user();
        $article = $user->articles()->create([
            "title" => $request->title,
            "body" => $request->body,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Article created successfully",
            "data" => $article,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $articles = $user->articles()->with("comments")->find($id);

        if (!$articles) {
            return response()->json([
                "success" => false,
                "message" => "Article not found"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $articles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(request()->all(), [
            "title" => "required|string",
            "body" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // check if article exist
        $user = auth()->user();
        $article = $user->articles()->find($id);

        // if article doesn't exist
        if (!$article) {
            return response()->json([
                "success" => false,
                "message" => "Article not found"
            ], 404);
        }

        // if article exist
        $article->update([
            "title" => $request->title,
            "body" => $request->body,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Article updated successfully",
            "data" => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // check if article exist
        $user = auth()->user();
        $article = $user->articles()->find($id);

        if (!$article) {
            return response()->json([
                "success" => false,
                "message" => "Article not found"
            ], 404);
        }

        $article->delete();

        return response()->json([
            "success" => true,
            "message" => "Article deleted successfully",
        ]);
    }
}

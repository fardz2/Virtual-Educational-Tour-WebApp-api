<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::get();
        return response()->json(['data' => $article]);
    }
    public function store(Request $request)
    {
        $user = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'content' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Article::create([
            "user_id" => $user,
            "title" => $request->title,
            "slug_title" => Str::slug($request->title, '-'),
            "content" => $request->content
        ]);
        return response()->json(['message' => 'artikel berhasil ditambah']);
    }
    public function show($slug)
    {
        $article = Article::where("slug_title", $slug)->first();
        $user = User::find($article->user_id);
        $article["username"] = $user->username;
        if ($article == null) {
            return response()->json(['message' => 'tidak ditemukan']);
        }
        return response()->json(['data' => $article]);
    }
}

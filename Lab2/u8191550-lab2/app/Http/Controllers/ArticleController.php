<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Показать список всех статей.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showArticles(Request $request)
    {
        $token = $request->input('tokenInput');
        $name = $request->input('nameInput');
        $tag = $request->input('tagInput');

        if ($tag == "") {
            $articles = DB::table('articles')
                            ->select('articles.id', 'name', 'token', 'content', 'created_at', 'author')
                            ->where('token', 'LIKE', '%'.$token.'%')
                            ->where('name', 'LIKE', '%'.$name.'%')          
                            ->orderBy('articles.id', 'asc');
        }
        else {
            $articles = DB::table('articles')
                            ->select('articles.id', 'articles.name', 'articles.token', 'content', 'created_at', 'author')
                            ->where('articles.token', 'LIKE', '%'.$token.'%')
                            ->where('articles.name', 'LIKE', '%'.$name.'%')
                            ->where('tags.name', 'LIKE', '%'.$tag.'%')
                            ->leftJoin('articles_tags', 'articles.id', '=', 'articles_tags.article_id')   
                            ->join('tags', 'tags.id', '=', 'articles_tags.tag_id')
                            ->distinct()                               
                            ->orderBy('articles.id', 'asc');
        }
        
        return view('posts', ['articles' => $articles->paginate(15)]);
    }

    public function showArticle(Request $request, string $code) 
    {
        $article = Article::where('token', '=', $code)
                            ->firstOrFail();
        $tags = [];
        $tags = DB::table('articles')
                        ->select('tags.name')
                        ->leftJoin('articles_tags', 'articles_tags.article_id', '=', 'articles.id')
                        ->join('tags', 'articles_tags.tag_id', '=', 'tags.id')
                        ->where('articles.id', '=', $article->id)
                        ->paginate(15);
        
        return view('posts_code', ['article' => $article, 'tags' => $tags]);
    }
}

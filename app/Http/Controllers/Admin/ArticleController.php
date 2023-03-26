<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\Article\GetArticlesAction;
use App\Http\Actions\Article\ShowArticleAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
  public function __construct(protected GetArticlesAction $getArticlesAction, protected ShowArticleAction $showArticleAction)
  {
  }

  public function index(Request $request)
  {
    $articles = $this->getArticlesAction->get($request);

    return view('admin.articles.index', compact('articles'));
  }
}

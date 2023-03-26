<?php

namespace App\Http\Controllers;

use App\Http\Actions\Article\GetArticlesAction;
use App\Http\Actions\Article\ShowArticleAction;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
  public function __construct(protected GetArticlesAction $getArticlesAction, protected ShowArticleAction $showArticleAction)
  {
  }

  public function index(Request $request)
  {
    $articles = $this->getArticlesAction->get($request);

    return ArticleResource::collection($articles);
  }

  public function show(Request $request, $slug)
  {
    $article = $this->showArticleAction->get($slug);

    return ArticleResource::make($article);
  }
}

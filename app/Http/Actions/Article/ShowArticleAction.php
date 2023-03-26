<?php

namespace App\Http\Actions\Article;

use App\Models\Article;

class ShowArticleAction
{
  public function get(string $slug)
  {
    try {
      return Article::published()->bySlug($slug)->first();
    } catch (\Exception $exception) {

    }
  }

}
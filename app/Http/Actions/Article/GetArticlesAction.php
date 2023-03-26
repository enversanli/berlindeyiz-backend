<?php

namespace App\Http\Actions\Article;

use App\Models\Article;
use Illuminate\Http\Request;

class GetArticlesAction
{
  public function get(Request $request, string $slug = null)
  {
    try {
      return  Article::published()->with('translations', function ($q) use ($slug){
        return $q->where('locale', 'tr');
      })->paginate();

    } catch (\Exception $exception) {

    }
  }
}
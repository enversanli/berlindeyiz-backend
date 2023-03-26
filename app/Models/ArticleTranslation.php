<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ArticleTranslation extends Model
{
  use HasFactory;

  public function article(): BelongsTo
  {
    return $this->belongsTo(Article::class);
  }

  public function scopeBySlug(Builder $query, string $slug){
    return $query->where('slug', $slug);
  }

}

<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model implements TranslatableContract
{
  use HasFactory;
  use Translatable;

  protected array $translatedAttributes = [
    'title', 'slug', 'title_slug', 'content', 'locale', 'meta', 'title_long', 'structured_data'
  ];

  protected $hidden = [
    'content', 'rendered_content', 'status', 'locale', 'meta', 'translations',
    'publish_date', 'author_id', 'note', 'created_at', 'updated_at', 'deleted_at',
    'slug', 'title_slug', 'title_long',
  ];

  protected $appends = [
    'link'
  ];

  protected $casts = [
    'publish_date' => 'datetime',
  ];

  public function author(): BelongsTo
  {
    return $this->belongsTo(Author::class);
  }

  public function isPublished(): bool
  {
    return $this->publish_date && now()->isAfter($this->publish_date);
  }

  //To search the article's translation table by publish_date and locale
  public function translations(): HasMany
  {
    return $this->hasMany(ArticleTranslation::class, 'article_id');
  }

  public function scopePublished(Builder $query, bool $withoutLocale = false): Builder
  {
    return $query->where('status', 'published');
  }

  public function scopeBySlug(Builder $query, string $slug): Builder
  {
    return $query->whereHas('translations', function ($q) use ($slug) {
      return $q->where('slug', $slug);
    });
  }

  public function getLinkAttribute(): string
  {
    $translation = $this->translations->where('locale', 'tr')->first();

    return config('app.url') . '/articles/' . $translation->slug;
  }
}

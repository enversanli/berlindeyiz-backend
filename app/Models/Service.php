<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'meta' => 'array'
  ];

  protected $telegramColumn = 'sent_to_tegram';

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function business()
  {
    return $this->belongsTo(Business::class, 'business_id', 'id');
  }

  public function guide()
  {
    return $this->hasOne(ServiceGuide::class, 'service_id', 'id');
  }

  public function type()
  {
    return $this->belongsTo(Type::class);
  }

  public function questions()
  {
    return $this->hasMany(ServiceQuestion::class, 'service_id', 'id');
  }

  public function systemRequirement()
  {
    return $this->hasOne(ServiceSystemRequirement::class, 'service_id', 'id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }

  public function city()
  {
    return $this->hasOne(City::class, 'id', 'city_id');
  }

  public function scopeApproved(Builder $query)
  {
    return $query->where('approved', true);
  }
}

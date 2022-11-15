<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Service extends Model
{
    use HasFactory;
    protected  $guarded = [];

    protected $telegramColumn = 'sent_to_tegram';

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function business(){
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function guide(){
        return $this->hasOne(ServiceGuide::class, 'service_id', 'id');
    }

    public function types(){
            return $this->belongsToMany(Type::class, 'service_types', 'service_id', 'type_id');
    }

    public function questions(){
        return $this->hasMany(ServiceQuestion::class, 'service_id', 'id');
    }

    public function systemRequirement(){
        return $this->hasOne(ServiceSystemRequirement::class, 'service_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function city(){
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function scopeApproved(Builder $query){
      return $query->where('approved', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'city_id',
        'district_id',
        'district_id',
        'address',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function services(){
        return $this->hasMany(Service::class, 'business_id', 'id');
    }

    public function city(){
      return $this->belongsTo(City::class);
    }

    public function scopePublic(Builder $query){
      return $query->where('is_public', true);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['main_id', 'type_id', 'name', 'slug', 'description'];

    public function type(){
      return $this->belongsTo(Type::class);
    }
}

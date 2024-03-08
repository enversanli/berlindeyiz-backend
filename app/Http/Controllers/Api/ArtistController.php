<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ArtistResource;
use App\Models\Artist;
use Illuminate\Support\Facades\Request;

class ArtistController
{
    public function index(Request $request)
    {
         $artists = Artist::paginate(20);

         return ArtistResource::collection($artists);

    }
}
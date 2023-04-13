<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use App\Support\ResponseMessage;

class AnnouncementController extends Controller
{
  public function index(){
    $announcements = Announcement::orderBy('created_at', 'DESC')->take(20)->get();

    return ResponseMessage::success(null, AnnouncementResource::collection($announcements));
  }
}
<?php

namespace App\Http\Controllers;


use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(){
        $announcements = Announcement::orderBy('created_at', 'DESC')->take(10)->get();

        return view('web.others.announcements')->with('announcements', $announcements);
    }
}

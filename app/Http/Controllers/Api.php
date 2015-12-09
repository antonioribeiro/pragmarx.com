<?php

namespace App\Http\Controllers;

use App\Services\YouTube;

class Api extends Controller
{
    public function forumVideos(YouTube $tube) {
        return response()->json($tube->listChannel('forumdesenvolvimento'));
    }
}

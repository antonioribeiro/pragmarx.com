<?php

namespace App\Services;

use Youtube as YoutubeService;

class YouTube
{
    public function listChannel($usuario) {
        return YoutubeService::getChannelByName($usuario);
    }
}

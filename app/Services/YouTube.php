<?php

namespace App\Services;

use Youtube as YoutubeService;

class YouTube
{
    public function listChannel($usuario) {
        $channel = YoutubeService::getChannelByName($usuario);

        $playlists = YoutubeService::getPlaylistsByChannelId($channel->id);

        $videos = [];

        foreach($playlists as $playlist)
        {
            $videos[$playlist->snippet->title] = YoutubeService::getPlaylistItemsByPlaylistId($playlist->id);
        }

        return $videos;
    }
}

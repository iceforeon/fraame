<?php

namespace App\Enums;

enum ItemType: string
{
    case Movie = 'movie';
    case TVShow = 'tvshow';
    case Anime = 'anime';

    public static function tmdbTypes()
    {
        return [
            ItemType::Movie,
            ItemType::TVShow,
        ];
    }
}

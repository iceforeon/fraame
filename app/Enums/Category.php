<?php

namespace App\Enums;

enum Category: string
{
    case Movie = 'movie';
    case TVShow = 'tvshow';
    case Anime = 'anime';

    public static function tmdbCategories()
    {
        return [
            self::Movie,
            self::TVShow,
        ];
    }
}

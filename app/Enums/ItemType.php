<?php

namespace App\Enums;

enum ItemType: string
{
    case Movie = 'movie';
    case TvShow = 'tvshow';
    case Anime = 'anime';
}

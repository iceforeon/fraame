<?php

namespace App\Http\Controllers;

use App\Enums\ItemType;
use App\Models\Movie;
use App\Models\TvShow;

class ItemPosterController extends Controller
{
    public function index($hashid)
    {
        if (! request()->hasAny(['key', 'type'])) {
            abort(404);
        }

        if (request()->get('key') !== config('app.poster_route_key')) {
            abort(404);
        }

        $itemType = ItemType::tryFrom(request()->get('type'));

        if (is_null($itemType)) {
            abort(404);
        }

        if ($itemType == ItemType::Movie) {
            $item = Movie::findOr($hashid, fn () => abort(404));
        }

        if ($itemType == ItemType::TVShow) {
            $item = TvShow::findOr($hashid, fn () => abort(404));
        }

        return view('item-poster', ['item' => $item]);
    }
}

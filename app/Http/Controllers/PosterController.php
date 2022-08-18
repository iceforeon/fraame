<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\Movie;
use App\Models\TVShow;

class PosterController extends Controller
{
    public function index($hashid)
    {
        if (! request()->hasAny(['key', 'category'])) {
            abort(404);
        }

        if (request()->get('key') !== config('app.poster_route_key')) {
            abort(404);
        }

        $category = Category::tryFrom(request()->get('category'));

        if (is_null($category)) {
            abort(404);
        }

        if ($category == Category::Movie) {
            $item = Movie::findOr($hashid, fn () => abort(404));
        }

        if ($category == Category::TVShow) {
            $item = TVShow::findOr($hashid, fn () => abort(404));
        }

        return view('poster', ['item' => $item]);
    }
}

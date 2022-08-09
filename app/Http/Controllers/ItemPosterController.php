<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ItemPosterController extends Controller
{
    public function index(Item $item)
    {
        if (request()->get('key') !== config('app.poster_route_key')) {
            abort(404);
        }

        return view('item-poster', ['item' => $item]);
    }
}

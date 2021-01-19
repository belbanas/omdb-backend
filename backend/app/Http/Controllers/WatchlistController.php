<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WatchlistController extends Controller
{
    //
    public function addMovie(Request $request)
    {
        try {
            $watchlist = new Watchlist();
            $watchlist->imdb_id = $request->imdb_id;
            $watchlist->user_id = auth()->user()->id;
            $watchlist->save();

            return response()->json([
                'watchlist' => $watchlist
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["message:" => "Something went wrong."], 400);
        }
    }

    public function showMovies(Request $request)
    {

    }
}

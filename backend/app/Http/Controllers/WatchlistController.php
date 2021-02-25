<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["message" => "Something went wrong."], 400);
        }
    }

    public function showMovies(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $watchlist = Watchlist::where('user_id', $user_id)->get();
            return response()->json([
                'watchlist' => $watchlist,
                'user_id' => $user_id
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 400);
        }
    }

    public function removeMovie(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $imdb_id = $request->imdb_id;
            $delete = Watchlist::where('imdb_id', $imdb_id)->where('user_id', $user_id)->delete();
            return response()->json([
                'message' => 'Movie deleted!'
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 400);
        }
    }

    public function sendRating(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $imdb_id = $request->imdb_id;
            $rating = $request->rating;
            $review = $request->review;
            $updateRating = Watchlist::where('imdb_id', $imdb_id)->where('user_id', $user_id)->update(['rating' => $rating, 'review' => $review]);
            return response()->json([
                'message' => 'Rating sent!'
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 400);
        }
    }

//
//    public function sendReview(Request $request)
//    {
//        try {
//            $user_id = auth()->user()->id;
//            $imdb_id = $request->imdb_id;
//            $review = $request->review;
//            $sendReview = Watchlist::where('imdb_id', $imdb_id)->where('user_id', $user_id)->update(['review' => $review]);
//            return response()->json([
//                'message' => 'Review sent!'
//            ], 200);
//        } catch (\Exception $e) {
//            Log::error($e->getMessage());
//            return response()->json(['message' => 'Something went wrong'], 400);
//        }
//    }

    public function reviewList(Request $request){
        try {
            $imdb_id = $request->imdb_id;
            $reviews = Watchlist::where('imdb_id', $imdb_id)->get();
            $result = [];
            foreach($reviews as $item){
                array_push($result, [
                    'username' => User::where('id', $item->user_id)->first()->name,
                    'review' => $item->review,
                    'rating' => $item->rating,
                    'id'=>$item->id
                ]);
            }
            return response()->json([
                'reviews' => $result

            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 400);
        }
    }
}

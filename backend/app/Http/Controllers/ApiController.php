<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getMoviesByTitle(Request $request)
    {
        try {
            $value = $request->value;
            $page = $request->page;
            $curl = curl_init();
            $url = "http://www.omdbapi.com/?apikey=530b6ee1&s=" . $value . "&page=" . $page;
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = (string)curl_exec($curl);
            curl_close($curl);
            return response()->json(json_decode($result),200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function getMovieById($id)
    {
        try {
            $imdbid = $id;
            $curl = curl_init();
            $url = 'http://www.omdbapi.com/?apikey=530b6ee1&i=' . $imdbid;
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = (string)curl_exec($curl);
            curl_close($curl);
            return response()->json(json_decode($result),200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}

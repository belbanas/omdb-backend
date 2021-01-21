<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|min:4',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json(['message' => 'User created successfully.'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => "Something went wrong"], 400);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => auth()->user()
            ], 200);
        } else {
            return response()->json(['message' => 'Unauthorised'], 401);
        }
//        try {
//            $user= User::where('email', $request->email)->first();
//            // print_r($data);
//            if (!$user || !Hash::check($request->password, $user->password)) {
//                return response([
//                    'message' => ['These credentials do not match our records.']
//                ], 404);
//            }
//
//            $token = $user->createToken('my-app-token')->plainTextToken;
//
//            $response = [
//                'user' => $user,
//                'token' => $token
//            ];
//
//            return response($response, 201);
//        } catch (\Exception $e) {
//            Log::error($e->getMessage());
//            return response()->json(['message' => 'Something went wrong'], 400);
//        }

    }

}

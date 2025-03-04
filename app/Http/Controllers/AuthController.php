<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{



    /**
     * Handle a login request to the application.
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        try {

            $validatedData = $request->validated();
            if (Auth::attempt($validatedData)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->accessToken;
                return response()->json(['token' => $token], 200);
            }
        } catch (\Exception $e) {
            echo "error => " . $e->getMessage();

        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

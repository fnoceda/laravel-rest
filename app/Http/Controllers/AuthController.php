<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{



    /**
     * Handle a login request to the application.
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {

            $validatedData = $request->validated();
            if (Auth::attempt($validatedData)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->accessToken;
                return response()->json(['access_token' => $token], 200);
            }
        } catch (\Exception $e) {
            echo "error => " . $e->getMessage();

        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Handle a login request to the application.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->all());
        $token = $user->createToken('authToken')->accessToken;
        return response()->json(['access_token' => $token], 200);
    }

    /**
     * Handle a login request to the application.
     * @return \Illuminate\Http\JsonResponse
     */
    public function me( ): JsonResponse
    {
         return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Handle a login request to the application.
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {

        try {
            Auth::user()->token()->revoke();
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }



    }




}

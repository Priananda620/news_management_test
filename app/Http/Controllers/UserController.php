<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Login user and create access token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error', 
                'errors' => $validator->errors()], 
                422
            );
        }

        // Check user credentials and create access token
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json(['user' => $user, 'access_token' => $accessToken]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function getUser(Request $request)
    {
        $user = $request->user();
        return new UserResource($user);
    }

    public function getUserRole(Request $request)
    {
        $user = Auth::user();
        return new UserResource($user);
    }

}

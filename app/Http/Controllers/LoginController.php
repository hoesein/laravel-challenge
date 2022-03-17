<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AuthResource;

class LoginController extends Controller
{
    public function login(AuthRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            $user = new AuthResource(User::where('email', $request->email)->first());

        }else{
            
            return response()->json([
                'status' => 404,
                'message' => 'Invalid credentials'
            ])
            ->setStatusCode(Response::HTTP_NOT_FOUND, Response::$statusTexts[Response::HTTP_NOT_FOUND]);

        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('User-Token')->plainTextToken
        ]);
    }
}

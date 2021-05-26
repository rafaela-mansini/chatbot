<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request){
        $validated = $request->validated();

        $validated['password'] = bcrypt($request->password);
        $user = User::create($validated);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([ 'user' => $user, 'access_token' => $accessToken, 'message' => trans('messages.userCreated') ]);
    }

    public function login(LoginUserRequest $request){
        $login = $request->validated();
        
        if(!auth()->attempt($login)){
            return response([ 'message' => 'Invalid credentials' ]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        
        return response()->json([ 'user' => auth()->user(), 'access_token' => $accessToken, 'message' => trans('messages.logged') ]);
    }
    
}

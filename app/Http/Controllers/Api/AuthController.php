<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/*
|   Call models
*/
use App\Models\User;

/*
|   Call helpers
*/
use Helper;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      			=> 'required|string|max:255',
            'email'     			=> 'required|string|max:255|unique:users',
            'password'  			=> 'required|string|min:8',
			'password_confirmation' => 'required_with:password|same:password|min:8'
        ]);

        if ($validator->fails()) 
		{			
            return response()->json([
				'success' 	=> false,
				'message'	=> Helper::render_message($validator->errors())
			]);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
			'success'		=> true,
			'message'		=> "New register is success, please do login",
            'data'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
				'success'	=> false,
                'message' 	=> 'Login failed or unauthorized'
            ], 200);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
			'success'		=> true,
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ], 200);
    }

    public function user()
	{
		if (auth('sanctum')->check())
		{
			return response()->json([
				'success'	=> true,
				'message' 	=> 'Logout Success',
				'user'		=> User::find(auth('sanctum')->user()->id)
			], 200);
		} else {
			return response()->json([
				'success'	=> false,
				'message' 	=> 'Unauthorized',
				'user'		=> []
			]);
		}
	}

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout Success'
        ]);
    }
}

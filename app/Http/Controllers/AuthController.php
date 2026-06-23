<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validations = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
        
        $request->validate($validations);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60),
        ]);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function login(Request $request)
    {
        $validations = [
            'email' => 'email|required',
            'password' => 'required',
        ];

        $request->validate($validations);

        $user = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (User::where('email', $request->email)->first() == null) {
            return response()->json(['message' => 'Invalid email or password!'], 401);
        }
        $user_type = User::where('email', $request->email)->first()->user_type;
        if ($user_type == 2) {
            if (Auth::attempt($user)) {
                $token = $request->user()->createToken('user_token')->plainTextToken;
                return response()->json([
                    'message' => 'success',
                    'user' => Auth::user()->toArray(),
                    'token' => $token,
                    'settings' => User::find(Auth::id())->settings,
                ]);
            } else {
                return response()->json(['message' => 'Invalid email or password!'], 401);
            }
        } else {
            return response()->json(['message' => 'Invalid email or password!'], 401);
        }
    }

    public function logout(Request $request)
    {
        // dd($request->user()->currentAccessToken());
        // exit();
        // Auth::logout();
        auth('sanctum')->user()->tokens()->delete();
        // auth()->logout();
        return response()->json([
            'message' => 'success',
        ]);
    }
}

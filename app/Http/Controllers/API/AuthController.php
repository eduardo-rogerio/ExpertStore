<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! auth()->attempt($credentials)) abort(401, 'Invalid Credencials');

        return response()->json(
            [
                'data' => [
                    'token' => auth()
                        ->user()
                        ->createToken('default')->plainTextToken
                ],
            ]
        );
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([], 204);
    }
}

<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function create()
    {
        $credentials = request(['phone', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            abort(422);
        }

        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return auth()->user();
    }

    private function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ]);
    }
}

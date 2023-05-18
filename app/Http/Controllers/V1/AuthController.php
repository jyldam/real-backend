<?php

namespace App\Http\Controllers\V1;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EmployeeResource;

class AuthController extends Controller
{
    public function store(): JsonResponse
    {
        $credentials = request(['phone', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            abort(400, 'Authentication failed');
        }

        return $this->respondWithToken($token);
    }

    public function destroy(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(): JsonResponse
    {
        $employee = Employee::with('user')
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return response()->json(new EmployeeResource($employee));
    }

    private function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ]);
    }
}

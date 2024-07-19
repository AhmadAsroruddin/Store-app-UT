<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
        $this->middleware('jwt.verify')->except(['login', 'register']);

    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
    
        // Handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }
    
        // Proceed with registration
        $result = $this->authService->register($request->only(['name', 'email', 'password']));
    
        return response()->json($result, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $this->authService->login($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'token' => $token
        ], 200);
    }

    
}

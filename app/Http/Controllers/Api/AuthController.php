<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 400);
        }
        $credentials = request(['email', 'password']);
        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => true, 'message' => 'Sorry!, Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3600,
            'user' => auth('api')->user()
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth('api')->logout();
        return response()->json(['error' => false, 'message' => 'Logout Successfully'], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 400);
        }
        $request['password'] = bcrypt($request->password);
        $user = User::create($request->except(['password_confirmation']));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);
    }

    public function AllPosts()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(2);
        return response()->json(['error' => false, 'allPosts' => $posts], 200);
    }
}

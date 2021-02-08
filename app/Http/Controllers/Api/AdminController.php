<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function loginAsAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 400);
        }
        $credentials = request(['email', 'password']);
        $token = auth('api-admin')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => true, 'message' => 'Sorry!, Unauthorized'], 401);
        }
        return response()->json([
            'message' => 'Successfully, Login',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expire_in' => auth('api-admin')->factory()->getTTL() * 3600,
        ], 200);
    }

    public function logoutAsAdmin(): \Illuminate\Http\JsonResponse
    {
        auth('api-admin')->logout();
        return response()->json(['error' => false, 'message' => 'Logout Successfully'], 200);
    }

    public function AdminInformation()
    {
        $admin = auth('api-admin')->user();
        return new AdminResource($admin);
//        return response()->json(auth('api-admin')->user());
    }

    public function createPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:70',
            'body' => 'required|max:1000',
            'image' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 400);
        }
        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);
        if (Str::contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        } else {
            $extension = 'png';
        }
        $fileName = Str::random() . '.' . $extension;
        $path = public_path() . '/image/post' . '/' . $fileName;
        File::put($path, $decoded);
        $request['image'] = 'image/post/' . $fileName;
        Post::create($request->all());
        return response()->json(['error' => false, 'message' => 'post created Successfully'], 200);

    }

    public function getPosts()
    {
        $posts = Post::orderBy('id', 'desc')->get();
        return response()->json(['error' => false, 'Posts' => $posts], 200);
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        if (!$post) {
            return response()->json(['error' => true, "post not Found"], 404);
        }
        $image = $post->image;
        if (file_exists($image)) {
            $image = public_path($image);
            unlink($image);
        }
        $post->delete();
        $posts = Post::all();
        return response()->json(['error' => false, 'Posts' => $posts], 200);
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if (!$post) {
            return response()->json(['error' => true, "post not Found"], 200);
        }
        $validator = Validator::make($request->except('image'), [
            'title' => 'required|max:70',
            'body' => 'required|max:1000',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 404);
        }
        if ($request->image) {
            $image = $post->image;
            if (file_exists($image)) {
                $image = public_path($image);
                unlink($image);
            }
            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);
            if (Str::contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } else {
                $extension = 'png';
            }
            $fileName = Str::random() . '.' . $extension;
            $path = public_path() . '/image/post' . '/' . $fileName;
            File::put($path, $decoded);
            $request['image'] = 'image/post/' . $fileName;
            $post->update($request->only('image'));
        }
        $post->update($request->except('image'));
        $posts = Post::all();
        return response()->json(['error' => false, 'Posts' => $posts], 200);
    }

    public function showPost($id)
    {
        $post = Post::findOrFail($id);
        if (!$post) {
            return response()->json(['error' => true, "post not Found"], 404);
        }
        return response()->json(['error' => false, 'data' => $post], 200);
    }
}

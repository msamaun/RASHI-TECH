<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
                'image' => 'required|image',
                'status' => 'required'
            ]);

            $user_id = Auth::id();
            $image = $request->file('image');
            $timestamp = now()->timestamp;
            $file_name = $image->getClientOriginalName();
            $image_name =("{$user_id}-{$timestamp}-{$file_name}");
            $image_url = "posts/{$image_name}";
            $image->move(public_path('posts'), $image_name);

            Post::create([
                'user_id' => $user_id,
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'status' => $request->input('status'),
                'image' => $image_url
            ]);
            return response()->json(['status' => 'success', 'message' => 'Post created successfully.']);
        }

        catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function updatePost(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
                'status' => 'required',
            ]);

            $user_id = Auth::id();
            $post_id = $request->input('id');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $t = time();
                $file_name = $image->getClientOriginalName();
                $image_name =("{$user_id}-{$post_id}-{$t}-{$file_name}");
                $image_url = "posts/{$image_name}";
                $image->move(public_path('posts'), $image_name);

                $filePath = $request->input('file_path');
                File::delete($filePath);

                return Post::where('id', $post_id)->where('user_id', $user_id)->update([
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                    'status' => $request->input('status'),
                    'image' => $image_url,
                    'user_id' => $user_id
                ]);

            }
            else {
                return Post::where('id', $post_id)->where('user_id', $user_id)->update([
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                    'status' => $request->input('status'),
                    'user_id' => $user_id
                ]);
            }
        }

        catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function deletePost(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            $user_id = Auth::id();
            $post_id = $request->input('id');
            $filePath = $request->input('file_path');
            File::delete($filePath);
            return Post::where('id', $post_id)->where('user_id', $user_id)->delete();

        }
        catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function getPostById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            $user_id = Auth::id();
            $post_id = $request->input('id');
            $rows = Post::where('id', $post_id)->where('user_id', $user_id)->first();
            return response()->json(['status' => 'success', 'data' => $rows]);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function postList()
    {
        try {
            $user_id = Auth::id();
            $rows = Post::where('user_id', $user_id)->get();
            return response()->json(['status' => 'success', 'data' => $rows]);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

}

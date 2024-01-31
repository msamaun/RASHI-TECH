<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
            User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' =>Hash::make( $request->input('password')),
            ]);

            return response()->json(['status' => 'success', 'message' => 'User created successfully']);

        }
        catch (Exception $exception) {

            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->input('email'))->first();
            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json(['status' => 'failed', 'message' => 'Invalid email or password']);
            }
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['status' => 'success', 'message' => 'Login successful', 'token' => $token]);
        }
        catch (Exception $exception) {

            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function profile(Request $request)
    {
       return Auth::user();
    }

    public function updateProfile(Request $request)
    {
        try{
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'bio' => 'required|string|max:1000',
                'phone' => 'required|string|max:255',
                'image' => 'required|image|max:255',
            ]);
            $user_id = Auth::id();
            $image = $request->file('image');
            $t = time();
            $filename = $image->getClientOriginalName();
            $image_name =("{$user_id}-{$t}-{$filename}");
            $image_url = "uploads/{$image_name}";

            $image->move(public_path('uploads'), $image_name);

            $filePath = $request->input('file_path');
            File::delete($filePath);

            User::where('id', Auth::user()->id)->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'bio' => $request->input('bio'),
                'phone' => $request->input('phone'),
                'image' => $image_url,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Profile updated successfully']);
        }
        catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }
}

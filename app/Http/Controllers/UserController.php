<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

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

    public function profile()
    {
       return Auth::user();
    }

    public function updateProfile(Request $request)
    {
        try{
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'mobile' => 'required|string|max:255',
            ]);

            User::where('id', Auth::user()->id)->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'mobile' => $request->input('mobile'),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Profile updated successfully']);
        }
        catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
    }

    public function sentOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
            ]);
            $email = $request->input('email');
            $otp = rand(100000, 999999);
            $count = User::where('email', $email)->count();

            if ($count > 0) {
                Mail::to($email)->send(new OTPMail($otp));
                User::where('email','=',$email)->update(['otp' => $otp]);
                return response()->json(['status' => 'success', 'message' => 'Otp sent successfully']);
            }
            else {
                return response()->json(['status' => 'failed', 'message' => 'Email not found']);
            }
        }
        catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
           $request->validate([
               'email' => 'required|string|email',
               'otp' => 'required|string',
           ]);
           $email = $request->input('email');
           $otp = $request->input('otp');

           $user = User::where('email', $email)->where('otp', $otp)->first();

           if (!$user) {
               return response()->json(['status' => 'failed', 'message' => 'Invalid otp']);
           }

           User::where('email','=', $email)->update(['otp' => 0]);
           $token = $user->createToken('authToken')->plainTextToken;
           return response()->json(['status' => 'success', 'message' => 'Otp verified successfully', 'token' => $token]);
        }
        catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
            ]);
            $id = Auth::id();
            $password = $request->input('password');
            User::where('id', $id)->update(['password' => Hash::make($password)]);
            return response()->json(['status' => 'success', 'message' => 'Password changed successfully']);

        }
        catch (Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

}

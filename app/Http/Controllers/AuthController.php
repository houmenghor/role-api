<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Namshi\JOSE\JWT;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'nullable|integer|min:1|exists:roles,id',
            'is_active' => 'nullable|boolean|in:1,0',
            'phone' => 'nullable|string|max:15|unique:user_profiles,phone',
            'dob' => 'nullable|date',
            'photo' => 'nullable|file|mimetypes:image/jpg,image/png,image/webp,image/gif,image/jpeg|max:1024',
        ]);
        $user = new User();
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = 1;
        $user->is_active = 1;
        $user->save();

        $photo = 'userProfile/no_profile.jpg';
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('userProfile', 'public');
        }

        $user->userProfile()->create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'dob' => $request->input('dob'),
            'photo' => $photo,
            'gender' => $request->input('gender')
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Register successfully!',
            'data' => new UserResource($user)
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);
        $user = User::where('email', $request->input('email'))->first(['email', 'password']);
        if (! $token = JWTAuth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'result' => false,
                'message' => 'Login failed, please try again'
            ]);
        }
        return response()->json([
            'result' => true,
            'message' => 'Login successfully!',
            'data' => [
                'email' => $user->email,
                'token' => $token
            ]
        ]);
    }
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'result' => true,
                'message' => 'Logout successfully!'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }
    public function forgetPassword(Request $request){
        $request->validate([
            'email' => ['required','email']
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if(!$user){
            return response()->json([
                'result' => false,
                'message' => 'email not found'
            ]);
        }
        $otp = rand(100000, 999999);
        Cache::put('opt_sent_' . $user->email,$otp, now()->addMinute(1));
        Mail::to($user->email)->queue(new ForgetPassword($otp));
        return response()->json([
            'result' => true,
            'message' => 'OPT sent to your email...'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = new User();
        $users = $users->with(['role','userProfile'])->get();
        return response()->json([
            'result' => true,
            'message' => 'Get all user successfully!',
            'data' => UserResource::collection($users)
        ]);
    }
}

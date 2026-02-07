<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
        'first_name'   => 'required|string|max:100',
        'last_name'    => 'required|string|max:100',
        'email'        => 'nullable|email|unique:users,email',
        'phone_number'=> 'nullable|string|unique:users,phone_number',
        'password'     => 'required|min:6|confirmed',
        ]);
    $validated = Validator::make($request->all(), [
        'first_name'   => 'required|string|max:100',
        'last_name'    => 'required|string|max:100',
        'email'        => 'nullable|email|unique:users,email',
        'phone_number'=> 'nullable|string|unique:users,phone_number',
        'password'     => 'required|min:6|confirmed',
        ]);
if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try{

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);



          return response()->json([
            'message' => 'Registered successfully',
            'user' => $user
        ], 201);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],403);
        }
    }


public function login(Request $request)
{
    $request->validate([
        'login' => 'required',
        'password' => 'required'
    ]);

    $login = trim($request->login);

$user = User::where('email', $login)
            ->orWhere('phone_number', $login)
            ->first();

    // ✅ STOP if user not found
    if (!$user) {
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    // ✅ STOP if password wrong
    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid password'
        ], 401);
    }

    // 🔑 Now safe to create token
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token
    ]);
}
}

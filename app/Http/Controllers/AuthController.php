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
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',

            // user must provide email OR phone
            'email' => 'nullable|email|unique:users,email|required_without:phone_number',
            'phone_number' => 'nullable|string|unique:users,phone_number|required_without:email',

            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // auto login after register
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->apiResponse(
        true,
         'User registered successfully',
          [
            'user' => $user,
            'token' => $token
        ], 201);


    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = trim($request->username);

        $user = User::where('email', $username)
                ->orWhere('phone_number', $username)
                ->first();


        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }


        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid password'
            ], 401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;

       return $this->apiResponse(
        true,
        'Login successful',
        [
        'user' => $user,
        'token' => $token
        ]);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

    return $this->apiResponse(
        true,
        'Logged out successfully');
    }

}

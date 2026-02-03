<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => $user
            ], 200);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],403);
        }
    }
}

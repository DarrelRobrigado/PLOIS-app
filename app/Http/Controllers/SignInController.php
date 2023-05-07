<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SignInController extends Controller
{
    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:accounts,acc_email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into table
        $success = DB::table('accounts')->insert([
            'acc_name' => $name,
            'acc_email' => $email,
            'acc_pass' => $hashed_password,
        ]);

        if ($success) {
            return redirect('/')->with('success', 'User created successfully.');
        } else {
            return response()->json(['message' => 'Failed to create user.'], 500);
        }
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'middleinitial' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        return User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middleinitial' => $request->middleinitial,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    public function addInformation(Request $request) 
    {
        UserInfo::create([
            'user_id' => $request->id,
            'contact' => $request->user_info['contact'],
            'gender' => $request->user_info['gender'],
            'address' => $request->user_info['address'],
            'birthdate' => $request->user_info['birthdate']
        ]);
    }
}

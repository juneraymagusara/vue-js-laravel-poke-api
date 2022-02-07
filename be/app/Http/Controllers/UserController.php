<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInfo;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getAllUsers() {
        return User::with('userInfo')->with('pokemon')->paginate(5);
    }

    public function getSpecificUser($id) {
        return User::with('userInfo')->with('pokemon')->find($id);
    }

    public function updateUser(Request $request) {
        $user = User::find($request->id);
        
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->middleinitial = $request->middleinitial;
        $user->email = $request->email;

        $user->save();

        $this->updateUserInfo($request);
    }
    public function updateUserInfo(Request $request) {
        $userInfo = UserInfo::find($request->id);

        if(is_null($userInfo)) {
            RegisterController::addInformation($request);
        } 

        $userInfo->user_id = $request->id;
        $userInfo->contact = $request->user_info['contact'];
        $userInfo->gender = $request->user_info['gender'];
        $userInfo->address = $request->user_info['address'];
        $userInfo->birthdate = $request->user_info['birthdate'];

        $userInfo->save();
    }
}

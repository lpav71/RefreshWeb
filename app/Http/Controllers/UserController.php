<?php

namespace App\Http\Controllers;

use App\Providers\UserCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function UserFindShow(Request $request)
    {
        $user       = Auth::user();
        $club_id    = $user->club_id;
        $searchUser = $request->searchUser;
        $user_id    = $user->id;
        if ($searchUser != null) {
            $fUserData = UserCommon::UsersFind($searchUser, $club_id);
            $fUser     = json_encode($fUserData);
        } else {
            $fUser = "";
        }
        return view('User.FindShow', compact('club_id', 'fUser', 'user_id'));
    }
}

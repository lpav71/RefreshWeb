<?php

namespace App\Http\Controllers;


use App\Http\Common\UserCommon;
use App\Models\Client;
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
        $user = Auth::user();
        $name = $user->name_auth; //Имя
        $surname = $user->surname; //Фамилия
        $fullName = $name . " " . $surname;
        $club_id = $user->club_id;
        $searchUser = $request->searchUser;
        $user_id = $user->id;
        if ($searchUser != null)
        {
            $fUserData = UserCommon::UsersFind($searchUser, $club_id);
            $fUser = json_encode($fUserData);
        }
        else {
            $fUser = "";
        }
        return view('User.FindShow', compact('fullName', 'club_id', 'fUser', 'user_id'));
    }
}

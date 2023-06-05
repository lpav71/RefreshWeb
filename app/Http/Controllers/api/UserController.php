<?php

namespace App\Http\Controllers\api;

use App\Http\Common\UserCommon;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use app\Http\Common;

class UserController extends Controller
{
    public function UsersFind(Request $request)
    {
        $searchUser = $request->user;
        $users = UserCommon::UsersFind($searchUser);
        return $users;
    }

    public function getPermisions(Request $request) {
        $permissions = UserCommon::getPermissions($request->user_id, $request->club_id);
        return $permissions;
    }
}

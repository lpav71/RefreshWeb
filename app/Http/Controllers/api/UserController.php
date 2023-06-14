<?php

namespace App\Http\Controllers\api;

use App\Http\Common\UserCommon;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use app\Http\Common;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function UsersFind(Request $request)
    {
        $searchUser = $request->user;
        $users = UserCommon::UsersFind($searchUser);
        return $users;
    }

    public function getPermisions(Request $request) {
        //$permissions = UserCommon::getPermissions($request->user_id, $request->club_id);
        //$permissions = UserAccess::where('club_id', $request->club_id)->where('user_id', $request->user_id)->first();
        //$permissions = DB::table('user_access')->where('club_id', $request->club_id)->where('user_id', $request->user_id)->first();

        $permissions = UserAccess::where(['club_id' => $request->club_id, 'user_id' => $request->user_id])->first();

        return $permissions;
    }
}

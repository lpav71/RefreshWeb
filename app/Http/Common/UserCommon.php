<?php

namespace App\Http\Common;

use App\Models\Client;
use App\Models\UserAccess;

class UserCommon
{
    public static function UsersFind($searchUser, $club_id)
    {
        $users = Client::where('login', 'ILIKE', '%'.$searchUser.'%')->where('club_id', $club_id)->get()->toArray();
        return $users;
    }

    public static function getPermissions($user_id, $club_id)
    {
        $permissions = UserAccess::where('club_id', $club_id)->where('user_id', $user_id)->first();
        return $permissions;
    }
}

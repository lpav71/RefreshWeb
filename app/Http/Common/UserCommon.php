<?php

namespace App\Http\Common;

use App\Models\Client;
use Illuminate\Http\Request;

class UserCommon
{
    public static function UsersFind($searchUser)
    {
        $users = Client::where('login', 'ILIKE', '%'.$searchUser.'%')->get()->toArray();
        return $users;
    }
}

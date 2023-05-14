<?php

namespace App\Http\Common;

use App\Models\Client;
use Illuminate\Http\Request;

class UserCommon
{
    public static function UsersFind($searchUser)
    {
        $users = Client::where('login', 'ILIKE', '%'.$searchUser.'%')->orWhere('phone', 'ILIKE', '%'.$searchUser.'%')->orWhere('email', 'ILIKE', '%'.$searchUser.'%')->orWhere('telegram_id', 'ILIKE', '%'.$searchUser.'%')
            ->orWhere('vk_id', 'ILIKE', '%'.$searchUser.'%')->orWhere('full_name', 'ILIKE', '%'.$searchUser.'%')->get()->toArray();
        return $users;
    }
}

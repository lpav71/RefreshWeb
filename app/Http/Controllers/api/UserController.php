<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UsersFind(Request $request)
    {
        $searchUser = $request->user;
        $users = Client::where('login', 'ILIKE', '%'.$searchUser.'%')->orWhere('phone', 'ILIKE', '%'.$searchUser.'%')->orWhere('email', 'ILIKE', '%'.$searchUser.'%')->orWhere('telegram_id', 'ILIKE', '%'.$searchUser.'%')
            ->orWhere('vk_id', 'ILIKE', '%'.$searchUser.'%')->orWhere('full_name', 'ILIKE', '%'.$searchUser.'%')->get()->toArray();
        return $users;
    }
}

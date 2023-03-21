<?php

namespace App\Http\Controllers;


use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function UserFindShow()
    {
        $user = Auth::user();
        $name = $user->name_auth; //Имя
        $surname = $user->surname; //Фамилия
        $fullName = $name . " " . $surname;
        return view('User.FindShow', compact('fullName'));
    }
}

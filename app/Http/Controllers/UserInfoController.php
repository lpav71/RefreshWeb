<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user    = Auth::user();
        $club_id = $user->club_id;

        return view('user_info.index', compact('user', 'club_id'));
    }
}

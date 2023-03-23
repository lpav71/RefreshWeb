<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $name = $user->name_auth; //Имя
        $surname = $user->surname; //Фамилия
        //$fullName = $name . " " . $surname;
        $fullName = Auth::user()->name;
        $clubId = $user->club_id;
        $club = Club::where('id', $clubId)->get();
        $userData = collect([
            'id' => $user->id,
            'name' => $user->name_auth,
            'surname' => $user->surname,
            'name_auth' => $user->name_auth
        ]);
        return view('home', compact('fullName', 'club', 'userData'));
    }
}

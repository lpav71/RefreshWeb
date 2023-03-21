<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $name = $user->name_auth; //Имя
        $surname = $user->surname; //Фамилия
        $fullName = $name . " " . $surname;
        return view ('game.index', compact('fullName'));
    }


}

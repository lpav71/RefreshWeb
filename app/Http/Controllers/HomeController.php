<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Contracts\Support\Renderable;
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
     * @return Renderable
     */
    public function index()
    {
        $user     = Auth::user();
        $fullName = Auth::user()->name;
        $clubId   = $user->club_id;
        $club     = Club::where('id', $clubId)->first();
        $userData = collect([
            'id'        => $user->id,
            'name'      => $user->name,
            'surname'   => $user->surname,
            'name_auth' => $user->name_auth,
            'club_id'   => $clubId,
            'user'      => $user
        ]);
        return view('home', compact('fullName', 'club', 'userData'));
    }

    public function dashboard()
    {
        $user    = Auth::user();
        $club_id = $user->club_id;
        $user_id = $user->id;
        return view('common.dashboard', compact('club_id', 'user_id'));
    }
}

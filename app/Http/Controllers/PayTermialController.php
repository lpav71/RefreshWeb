<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PayTermialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user    = Auth::user();
        $club_id = $user->club_id;

        return view('pay_terminal.index', compact('club_id'));
    }
}

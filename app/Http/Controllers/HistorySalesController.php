<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HistorySalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user    = Auth::user();
        $club_id = $user->club_id;

        return view('history_sales.index', compact('club_id'));
    }
}

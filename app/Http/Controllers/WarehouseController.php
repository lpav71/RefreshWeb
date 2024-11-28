<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user    = Auth::user();
        $club_id = $user->club_id;
        $user_id = $user->id;

        return view('warehouse.index', compact('club_id', 'user_id'));
    }
}

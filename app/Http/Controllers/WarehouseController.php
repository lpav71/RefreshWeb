<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $club_id = $user->club_id;

        return view('warehouse.index', compact('club_id'));
    }
}

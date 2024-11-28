<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TariffStatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user    = Auth::user();
        $club_id = $user->club_id;

        return view('tariff_statistic.index', compact('club_id'));
    }
}

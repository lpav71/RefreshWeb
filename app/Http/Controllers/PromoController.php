<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $club_id = $user->club_id;
        $promocodes = Promo::where('club_id', $club_id)->get();
        return view('promo.index', compact('club_id', 'promocodes'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user    = Auth::user();
        $club_id = $user->club_id;
        $comps   = Map::where('club_id', $club_id)->OrderBy('id_comp')->get();
        return view('map.index', compact('club_id', 'comps'));
    }
}

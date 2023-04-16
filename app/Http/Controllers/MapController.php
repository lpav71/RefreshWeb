<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $club_id = $user->club_id;
        $comps = Map::where('club_id', $club_id)->get();
        return view('map.index', compact('club_id', 'comps'));
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function getZone(Request $request)
    {
        $clubId = $request->club_id;
        $zone = Zone::where('club_id', $clubId)->orderBy('num')->get();
        return $zone;
    }
}

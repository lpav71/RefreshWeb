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
    public function addZone(Request $request)
    {
        $club_id = $request->club_id;
        $zoneName = $request->zone_name;
        $maxNum = Zone::where('club_id', $club_id)->selectRaw('MAX(num)')->first()->max;
        $zone = new Zone;
        $zone->num = $maxNum + 1;
        $zone->club_id = $club_id;
        $zone->name = $zoneName;
        $zone->save();
        return $zone;
    }
}

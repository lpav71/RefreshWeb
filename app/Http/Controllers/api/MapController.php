<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Map;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function saveMapPosition(Request $request)
    {
        $comp = $request->comp;
        $map = Map::where('id_comp',$comp)->first();
        $map->pos_x = $request->posx;
        $map->pos_y = $request->posy;
        $map->save();
        return $map;
    }
    public function getMapPosition(Request $request)
    {
        $mapZone = DB::table('zone')->rightJoin('map', function($join)
        {
            $join->on('zone.club_id','=','map.club_id');
            $join->on('zone.num', '=', 'map.zone');
        })->where('map.club_id', '=', 1)->where('map.id_comp', '=', 1)->orderBy('id_comp', 'asc')->get()->toArray();
        $zone = Zone::where('club_id', 1)->get()->toArray();
        $map = Map::where(['club_id'=>$request->club_id])->orderBy('id_comp')->get()->toArray();
        $outData = array(
            'zone' => $zone,
            'map' => $map,
            'mapZone' => $mapZone
        );
        return $outData;
    }
    public function saveNewPosition(Request $request)
    {
        $map = new Map;
        $map->pos_x = $request->posx;
        $map->pos_y = $request->posy;
        $map->zone = $request->zone;
        $map->id_comp = $request->id_comp;
        $map->club_id = 1;
        $map->save();
    }
}

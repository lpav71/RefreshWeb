<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TariffController extends Controller
{
    public function getTariff0(Request $request)
    {
        $club_id = $request->club_id;
        $tariff = DB::table('price')
            ->select('price', 'tariff_type', DB::raw("to_char(time_start, 'HH24:MI') as time_start"), DB::raw("to_char(time_stop, 'HH24:MI') as time_stop"), 'time_fixed', 'name')
            ->where([
                ['price.club_id', '=', $club_id],
                ['tariff_type', '=', 0],
            ])
            ->get();
        return $tariff;
    }

    public function getTariff1(Request $request)
    {
        $club_id = $request->club_id;
        $tariff = DB::table('price')
            ->select('price', 'tariff_type', DB::raw("to_char(time_start, 'HH24:MI') as time_start"), DB::raw("to_char(time_stop, 'HH24:MI') as time_stop"), 'time_fixed', 'name')
            ->where([
                ['price.club_id', '=', $club_id],
                ['tariff_type', '=', 1],
            ])
            ->get();
        return $tariff;
    }
}

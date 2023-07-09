<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    public function save(Request $request)
    {
        $promo = new Promo();
        $promo->club_id = $request->club_id;
        $promo->promo = $request->promo;
        $promo->description = $request->description;
        $promo->date_start = $request->date_start;
        $promo->date_stop = $request->date_stop;
        $promo->max_activation = $request->max_activation;
        $promo->num = $request->num;
        $promo->status = true;
        $promo->save();
    }

    public function get(Request $request) {
        $promocodes = Promo::where('club_id', $request->club_id)->get();
        return $promocodes;
    }

    public function codes(Request $request)
    {
        $club_id = $request->club_id;
        $promoCode = $request->promo_code;
        $promo = DB::table('promo')
            ->where('date_stop', '>', DB::raw('NOW()'))
            ->whereColumn('activations', '<', 'max_activation')
            ->where('club_id', $club_id)
            ->where('promo', $promoCode)
            ->first();
        if ($promo === null)
            $promo = array();
        return $promo;
    }
}

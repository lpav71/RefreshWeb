<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

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
        $promo->status = true;
        $promo->save();
    }
}

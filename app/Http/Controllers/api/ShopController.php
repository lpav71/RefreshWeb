<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function getAll(Request $request)
    {
        $store = Store::where('club_id', $request->club_id)->get();
        return($store);
    }
}

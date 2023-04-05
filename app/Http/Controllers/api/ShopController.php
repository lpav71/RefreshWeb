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
    public function find(Request $request)
    {
        $searchText = $request->search;
        $products = Store::where('product', 'ILIKE', '%'.$searchText.'%')->orWhere('product_param', 'ILIKE', '%'.$searchText.'%')->get()->toArray();
        return $products;
    }
}

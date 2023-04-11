<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ProductType;
use App\Models\Store;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function getAll(Request $request)
    {
        $store = Store::where('store.club_id', $request->club_id)->join('product_type', function($join)
        {
            $join->on('store.types', 'product_type.types');
        })->get();
        return($store);
    }
    public function find(Request $request)
    {
        $searchText = $request->search;
        $products = Store::where('product', 'ILIKE', '%'.$searchText.'%')->orWhere('product_param', 'ILIKE', '%'.$searchText.'%')->get()->toArray();
        return $products;
    }
    public function searchClient(Request $request)
    {
        $client = Client::where('login', $request->login)->first();
        return $client;
    }
}

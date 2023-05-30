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
        $store = Store::select('store.id as storeid', '*')
            ->where('store.club_id', $request->club_id)
            ->where('product_type.club_id', $request->club_id)
            ->join('product_type', function($join) {
                $join->on('store.types', 'product_type.types');
            })
            ->orderBy('storeid')
            ->get();

        $productType = ProductType::where('club_id', $request->club_id)->get();
        $outData = array($store, $productType);
        return($outData);
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
    public function addEdit(Request $request)
    {
        $product = $request->product;
        $price = $request->price;
        $num = $request->num;
        $barcode = $request->barcode;
        $discount = $request->discount;
        $types = $request->types;
        $club_id = $request->club_id;
        $icon = $request->icon;
        $shell_show = $request->showInClient;
        $id = $request->storeid;
        if ($id == null) {
            $store = new Store();
            $store->product = $product;
            $store->price = $price;
            $store->num = $num;
            $store->barcode = $barcode;
            $store->discount = $discount;
            $store->types = $types;
            $store->club_id = $club_id;
            $store->icon = $icon;
            $store->shell_show = $shell_show;
            $store->save();
        }
        else {
            $store = Store::find($id);
            $store->product = $product;
            $store->price = $price;
            $store->num = $num;
            $store->barcode = $barcode;
            $store->discount = $discount;
            $store->types = $types;
            $store->icon = $icon;
            $store->shell_show = $shell_show;
            $store->save();
        }
        return $store;
    }
}

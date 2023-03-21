<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;

class TestController extends Controller
{
    public function index()
    {
        $b = new Blueprint('users');
        $b->string('name');
        return view ('test.index');
    }
    public function get(Request $request)
    {
        $phone = $request->phone;
        $all = $request->all();
        dd($all);
    }
}

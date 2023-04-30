<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;

class TestController extends Controller
{
    public function index()
    {
        $data = [
            ['start_time' => '06:00', 'end_time' => '23:59'],
            ['start_time' => '13:00', 'end_time' => '19:15'],
            ['start_time' => '13:00', 'end_time' => '17:30'],
        ];
        return view('test.index', ['data' => $data]);
    }
}

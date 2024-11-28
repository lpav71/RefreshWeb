<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('test.index', compact('user'));
    }
}

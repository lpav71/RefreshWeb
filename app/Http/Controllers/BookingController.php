<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        $club_id = $user->club_id;

        return view('booking.index', compact('club_id'));
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function getAllClients(Request $request)
    {
        $club_id = $request->club_id;
        $booking = DB::table('booking')
            ->where('booking.club_id', $club_id)
            ->where('clients.club_id', $club_id)
            ->where('booking.status', 0)
            ->join(
            'clients',
            'booking.user_id',
            '=',
            'clients.id'
        )
            ->select(DB::raw('booking.map_comp_id, clients.login, to_char(booking.time_start, \'HH24:MI\') as time_start'))
            ->get();
        return $booking;
    }
}

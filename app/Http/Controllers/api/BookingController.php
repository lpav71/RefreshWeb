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
            ->where('zone.club_id', $club_id)
            ->where('price.club_id', $club_id)
            ->where('booking.status', 0)
            ->join(
            'clients',
            'booking.user_id',
            '=',
            'clients.id'
        )
            ->join(
            'zone',
                'booking.id_zone',
                '=',
                'zone.id'
            )
            ->join(
                'price',
                'booking.price_id',
                '=',
                'price.id'
            )
            ->select(DB::raw('booking.id, clients.phone, clients.email, price.name as tariff, zone.name as zone, booking.map_comp_id, clients.login, to_char(booking.time_start, \'HH24:MI\') as time_start, to_char(booking.time_start, \'DD.MM.YYYY\') as date'))
            ->get();
        return $booking;
    }
    public function cancelBooking(Request $request)
    {
        $id = $request->id;
        $booking = Booking::find($id);
        $booking->status = 4;
        $booking->save();
        return $booking;
    }
}

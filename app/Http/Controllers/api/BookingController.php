<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Map;
use Carbon\Carbon;
use DateTime;
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

    public function draw(Request $request)
    {
        $club_id = $request->club_id;
        $time_start = $request->time_start;
        $time_start = Carbon::parse($time_start)->setTime(0, 0, 0);
        $time_stop = Carbon::parse($time_start)->setTime(23, 59, 0);

        $maps = DB::table('map')
            ->leftJoin('booking as b', 'map.id_comp', '=', 'b.map_comp_id')
            ->join('clients as c', 'map.user_id', '=', 'c.id')
            ->where('map.club_id', $club_id)
            ->where('b.time_start', '>=', $time_start)
            ->orWhere('time_stop', '<', $time_stop)
            ->orWhereNull('b.time_start')
            ->orWhereNull('b.time_stop')
            ->groupBy('id_comp')
            ->orderBy('id_comp', 'asc')
            ->select(DB::raw("id_comp,
        (
            SELECT json_agg(row(d.time_start, d.time_stop, clients.login, clients.id)
            ORDER BY d.time_start ASC)
            FROM clients
            left join booking d on clients.id=d.user_id
            WHERE map.id_comp = d.map_comp_id
            GROUP BY d.map_comp_id
        ) AS fulldata"))->get();

        $drawData = array();
        foreach ($maps as $map) {
            $recData = array();
            $rec = json_decode($map->fulldata, true);
            $recData['fulldata'] = $rec;
            $recData['id_comp'] = $map->id_comp;
            array_push($drawData, $recData);
        }
// Обрезка time_stop до f1 даты и времени 23:59 -----------------------------------------------------------------------
        foreach ($drawData as &$item) {
            if (!is_null($item['fulldata'])) {
                foreach ($item['fulldata'] as &$data) {
                    $f1 = Carbon::parse($data['f1'])->setTime(0, 0, 0);
                    $f2 = Carbon::parse($data['f2'])->setTime(0, 0, 0);
                    if ($f1->notEqualTo($f2)) {
                        $data['f2'] = $f1->setTime(23, 59, 0)->toDateTimeString();
                    }
                }
            }
        }
// ~Обрезка time_stop до f1 даты и времени 23:59 ----------------------------------------------------------------------

// Расчет diff и offset -----------------------------------------------------------------------------------------------

        $newDrawData = array_map(function ($draw) {
            $newDraw = [
                'id_comp' => $draw['id_comp'],
                'fulldata' => null,
            ];

            if (isset($draw['fulldata'])) {
                $newFulldata = [];

                $prevF2 = null;
                array_map(function ($data) use (&$newFulldata, &$prevF2) {
                    $newData = [
                        'f1' => $data['f1'],
                        'f2' => $data['f2'],
                        'f3' => $data['f3'],
                    ];

                    $newData['diff'] = Carbon::parse($data['f2'])->diffInMinutes(Carbon::parse($data['f1']));
                    if ($prevF2 !== null) {
                        $newData['offset'] = Carbon::parse($data['f1'])->diffInMinutes(Carbon::parse($prevF2));
                    } else {
                        $newData['offset'] = Carbon::parse($data['f1'])->diffInMinutes(Carbon::parse($data['f1'])->startOfDay());
                    }

                    $newFulldata[] = $newData;
                    $prevF2 = $data['f2'];
                }, $draw['fulldata']);

                $newDraw['fulldata'] = $newFulldata;
            }

            return $newDraw;
        }, $drawData);

// ~Расчет diff и offset ----------------------------------------------------------------------------------------------

        return $newDrawData;
    }
}


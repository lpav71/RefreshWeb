<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Map;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookingController extends Controller
{
    protected $booking;

    /**
     * @param Booking $booking
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }


    public function getAllClients(Request $request)
    {
        $club_id = $request->club_id;
        return $this->booking->getAllClientsBooking($club_id);
    }

    public function cancelBooking(Request $request)
    {
        $id = $request->id;
        return $this->booking->cancelBookingBooking($id);
    }

    public function draw(Request $request)
    {
        $club_id    = $request->club_id;
        $time_start = $request->time_start;
        $time_start = Carbon::parse($time_start)->setTime(0, 0, 0);
        $time_stop  = Carbon::parse($time_start)->setTime(23, 59, 0);

        $maps = $this->booking->getMaps($time_start, $time_stop, $club_id);

        $drawData = [];
        foreach ($maps as $map) {
            $recData             = [];
            $rec                 = json_decode($map->fulldata, true);
            $recData['fulldata'] = $rec;
            $recData['id_comp']  = $map->id_comp;
            $drawData[]          = $recData;
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

        // ~Расчет diff и offset ----------------------------------------------------------------------------------------------

        return array_map(function ($draw) {
            $newDraw = [
                'id_comp'  => $draw['id_comp'],
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
                    $prevF2        = $data['f2'];
                }, $draw['fulldata']);

                $newDraw['fulldata'] = $newFulldata;
            }

            return $newDraw;
        }, $drawData);
    }

    public function reservations(Request $request): Collection
    {
        $client_id = $request->client_id;
        return $this->booking->getNotification($client_id);
    }

    public function userCash(Request $request): Collection
    {
        $client_id = $request->client_id;
        return $this->booking->getNotificationUserCash($client_id);
    }

    public function getAllBookingsPerDay(Request $request): array
    {
        $club_id = $request->club_id;
        $outData = [];
        $now     = Carbon::now()->startOfDay();
        for ($i = 0; $i < 24; $i++) {
            $count     = $this->booking->getBookingPerTime($now, $i, $club_id);
            $outData[] = $count;
        }
        return $outData;
    }

    public function getAllBookingsHours(Request $request)
    {
        $club_id     = $request->club_id;
        $now         = Carbon::now()->startOfDay();
        $currentHour = Carbon::now()->setTimezone('Europe/Moscow')->hour;

        $outData = array_map(
            fn($i) => $this->booking->getBookingPerTime($now, $i, $club_id),
            range(0, $currentHour - 1)
        );

        $computerCount = Map::where('club_id', $club_id)->count();

        $blocks = [
            array_slice($outData, 0, 8),
            array_slice($outData, 8, 4),
            array_slice($outData, 12, 6),
            array_slice($outData, 18, 6)
        ];

        return array_map(function ($block) use ($computerCount) {
            return $computerCount > 0 ? array_sum(array_map(fn($b) => $b / $computerCount * 100, $block)) : 0;
        }, $blocks);
    }

    public function getAllBookingsPerDayAPI(Request $request)
    {
        $booking = file_get_contents("http://45.135.165.89:6150/api/web/Booking/getAllBookingsPerDay?ClubId=$request->club_id");
        return json_decode($booking, true);
    }


}


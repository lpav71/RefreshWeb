<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Zone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TariffController extends Controller
{
    public function getTariff0(Request $request)
    {
        $club_id = $request->club_id;
        $tariff = DB::table('price')
            ->select('price', 'tariff_type', DB::raw("to_char(time_start, 'HH24:MI') as time_start"), DB::raw("to_char(time_stop, 'HH24:MI') as time_stop"), 'time_fixed', 'name')
            ->where([
                ['price.club_id', '=', $club_id],
                ['tariff_type', '=', 0],
            ])
            ->get();
        return $tariff;
    }

    public function getTariff1(Request $request)
    {
        $club_id = $request->club_id;
        $tariff = DB::table('price')
            ->select('price', 'tariff_type', DB::raw("to_char(time_start, 'HH24:MI') as time_start"), DB::raw("to_char(time_stop, 'HH24:MI') as time_stop"), 'time_fixed', 'name')
            ->where([
                ['price.club_id', '=', $club_id],
                ['tariff_type', '=', 1],
            ])
            ->get();
        return $tariff;
    }
    public function save(Request $request)
    {
        $all = $request->all();
        $club_id = $request->club_id;
        $name = $request->name;
        $week_day = $request->week_day;
        $id_zone = $request->id_zone;
        $booking_alive = $request->booking_alive;
        $add_block = json_decode($request->add_block);
        if (count($add_block) === 0) {
            return response()->json([
                'message' => 'Ошибка: неверный запрос',
            ], 400);
        }
        $error = false;
        try {
            DB::transaction(function () use (&$error, $name, $club_id, $week_day, $id_zone, $booking_alive, $add_block) {
                foreach ($add_block as $block) {
                    $price = new Price();
                    $price->club_id = $club_id;
                    $price->name = $name;
                    $price->week_day = $week_day;
                    $price->id_zone = $id_zone;
                    $price->booking_alive = $booking_alive;
                    $price->time_start = $block->time_start;
                    $price->time_stop = $block->time_stop;
                    $price->price = $block->price;

                    if ($block->time_fixed == ''){
                        $block->time_fixed = null;
                    }
                    else
                        $price->time_fixed = $block->time_fixed;

                    if ($block->duration == ''){
                        $block->duration = 0;
                    }
                    else
                        $price->duration = $block->duration;

                    if($block->duration == 0 && $block->time_fixed == null) {
                        $price->tariff_type = 0;
                    }
                    else {
                        $price->tariff_type = 1;
                    }
                    try {
                        $price->save();
                        // продолжение работы программы после сохранения

                    } catch (\Exception $e) {
                        $error = true;
                    }
                }
                DB::commit();
            });
        }
        catch (Exception $e) {
            DB::rollBack();
            // Обработка исключения
        }
        if ($error){
            return response()->json([
                'message' => 'Ошибка: неверный запрос',
            ], 400);
        }
        else
        {
            return response()->json([
                'message' => 'Успех',
            ]);
        }
    }
    public function zone(Request $request)
    {
        $zone = Zone::where('club_id', $request->club_id)->get();
        return $zone;
    }
}

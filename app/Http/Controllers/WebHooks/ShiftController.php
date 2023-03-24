<?php

namespace App\Http\Controllers\WebHooks;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Control;
use App\Models\Finance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function close(Request $request)
    {
        $apikey = $request->apikey;
        $club = Club::where('api_key', $apikey)->first();
        $timeZone = $club->time_zone;
        $todayWithUTC = Carbon::now()->addHours(3)->addMinutes($timeZone)->toDateTimeString();
        $finance = Finance::where('status', true)->where('shift', $request->shift)->where('admin_id', $request->admin_id)->first();
        if ($finance != null) {
            $finance->status = false;
            $finance->close_shift = $todayWithUTC;
            $finance->save();
            $response = array(
                'status' => 'OK'
            );
            return $response;
        }
    }
    public function open(Request $request)
    {
        $apikey = $request->apikey;
        $admin_id = $request->admin_id;
        $admin_name = $request->admin_name;
        $shift = $request->shift;
        $cash_box_serial = $request->cash_box_serial;
        $club = Club::where('api_key', $apikey)->first();
        if ($club != null) {
            $finance = new Finance;
            $finance->admin_id = $admin_id;
            $finance->admin_name = $admin_name;
            $finance->club_id = $club->id;
            $finance->shift = $shift;
            $finance->cash_box_serial = $cash_box_serial;
            $finance->status = true;
            $s = $finance->save();
            $control = Control::all();
            if (count($control) > 0){
                $control[0]->shift_status = 'open';
                $control[0]->save();
            }
            else {
                $c = new Control;
                $c->shift_status = 'open';
                $c->save();
            }
            return $finance->id;
        }
        else
            return 0;
    }
}

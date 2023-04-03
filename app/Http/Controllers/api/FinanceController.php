<?php

namespace App\Http\Controllers\api;

use App\Events\MyEvent;
use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Control;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function getSmena(Request $request)
    {
        $clubId = $request->club_id;
        $finance = DB::table('finance')->select(DB::raw('cash, nocash, shop_cash, shop_nocash, to_char(open_shift, \'DD.MM.YYYY HH24:MI\') As time'))->where('status','true')->where('club_id', $clubId)->get();
        $shift = 'open';
        if (count($finance) == 0){
            $finance = DB::table('finance')->select(DB::raw('cash, nocash, shop_cash, shop_nocash, to_char(close_shift, \'DD.MM.YYYY HH24:MI\') As time'))
                ->where('status','false')->where('club_id', $clubId)
                ->orderBy('close_shift', 'desc')
                ->get();
            $shift = 'close';
        }
        $outData = array(
            'shift' => $shift,
            'finance' => $finance
        );
        return $outData;
    }

    public function findOpenShift(Request $request)
    {
        $club_id = $request->club_id;
        $finance = Finance::where('status', true)->where('club_id', $club_id)->get()->toArray();
        $count = count($finance);
        if ($count > 0) {
            $outData = array(
                'shiftStatus' => 'open'
            );
        }
        else {
            $outData = array(
                'shiftStatus' => 'close'
            );
        }
        return $outData;
    }

    public function getAllFinance()
    {
        $finance = DB::table('finance')->select(DB::raw('admin_name,shift, open_shift, close_shift, cash, cash_num, nocash, nocash_num, bonus, bonus_num,
         return_cash, return_cash_num, return_nocash, return_nocash_num, shop_cash,shop_cash_num, shop_nocash, shop_nocash_num, status, to_char(open_shift, \'DD.MM.YYYY HH24:MI\') As open_shift, to_char(close_shift, \'DD.MM.YYYY HH24:MI\') As close_shift'))->where('club_id', 1)->get();
        foreach ($finance as $fin) {
            if ($fin->status)
            {
                $fin->status = 'Смена открыта';
            }
            else {
                $fin->status = 'Смена закрыта';
            }
        }
        return $finance;
    }
    public function verifyOpenShift(Request $request)
    {
        $control = Control::where('user_id', $request->user_id)->get();
        if (count($control) > 0) {
            $ctrl = $control[0];
            $shiftStatus = $ctrl->shift_open;
            if ($shiftStatus === 'open') {
                $ctrl->shift_open = 'close';
                $ctrl->save();
                return 'open';
            }
            else
                return 'close';
        }
        return 'close';
    }
    public function verifyCloseShift(Request $request)
    {
        $control = Control::where('user_id', $request->user_id)->get();
        if (count($control) > 0) {
            $ctrl = $control[0];
            $shiftStatus = $ctrl->shift_close;
            if ($shiftStatus === 'open') {
                $ctrl->shift_close = 'close';
                $ctrl->save();
                return 'open';
            }
            else
                return 'close';
        }
        return 'close';
    }
    public function sendMassage()
    {
        event(new MyEvent('hello world'));
    }

    public function closePaymentWindow(Request $request)
    {
        $club = Club::where('api_key', $request->api_key)->first();
        if ($club !== null) {
            $data = array(
                'id' => $club->id,
                'operation' => 'close'
            );
            event(new MyEvent($data));
        }
    }
}

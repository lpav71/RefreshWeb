<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function getSmena()
    {
        $finance = DB::table('finance')->select(DB::raw('cash, nocash, shop_cash, shop_nocash, to_char(open_shift, \'DD.MM.YYYY HH24:MI\') As time'))->where('status','true')->where('club_id', 1)->get();
        $shift = 'open';
        if (count($finance) == 0){
            $finance = DB::table('finance')->select(DB::raw('cash, nocash, shop_cash, shop_nocash, to_char(close_shift, \'DD.MM.YYYY HH24:MI\') As time'))
                ->where('status','false')->where('club_id', 1)
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
}

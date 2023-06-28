<?php

namespace App\Http\Controllers\api;

use App\Http\Common\UserCommon;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use app\Http\Common;
use Illuminate\Support\Facades\DB;

class UserInfoController extends Controller
{
    public function shifts(Request $request)
    {
        $shifts = DB::table('finance')
            ->join('users', 'finance.admin_id', '=', 'users.id')
            ->select(DB::raw("to_char(finance.open_shift, 'DD.MM.YYYY HH24:MI') AS open_shift, to_char(finance.close_shift, 'DD.MM.YYYY HH24:MI') AS close_shift"))
            ->where('users.id', $request->user_id)
            ->orderBy('finance.shift', 'DESC')
            ->get();
        return $shifts;
    }
}

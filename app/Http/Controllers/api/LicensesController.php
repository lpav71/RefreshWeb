<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClubSteamAccount;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LicensesController extends Controller
{
    public function licenses(Request $request)
    {
        $result = DB::table('club_steam_account')
            ->select(DB::raw('count(steam_id) as account, club_id, steam_id, game'))
            ->groupBy('club_id', 'steam_id', 'game')
            ->get();
        return $result;
    }
    public function categorySave(Request $request)
    {
        $account = new ClubSteamAccount();
        $account->game = $request->category;
        $account->steam_id = $request->steam_id;
        $account->club_id = $request->club_id;
        $account->save();
        $id = $account->id;
        return $id;
    }
}

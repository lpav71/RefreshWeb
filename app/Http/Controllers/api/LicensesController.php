<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClubSteamAccount;
use Illuminate\Http\Request;

class LicensesController extends Controller
{
    protected ClubSteamAccount $clubSteamAccount;

    /**
     * @param ClubSteamAccount $clubSteamAccount
     */
    public function __construct(ClubSteamAccount $clubSteamAccount)
    {
        $this->clubSteamAccount = $clubSteamAccount;
    }

    public function licenses()
    {
        return $this->clubSteamAccount->getCountLicenses();
    }

    public function categorySave(Request $request)
    {
        $category = $request->category;
        $steam_id = $request->steam_id;
        $club_id  = $request->club_id;

        $account = $this->clubSteamAccount->getSteamAccount($category, $steam_id, $club_id);
        return $account->id;
    }
}

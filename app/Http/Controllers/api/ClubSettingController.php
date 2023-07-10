<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClubSetting;
use Illuminate\Http\Request;

class ClubSettingController extends Controller
{
    public  function disignData(Request $request)
    {
        $clubSetting = ClubSetting::where('club_id', $request->club_id)->first();
        return $clubSetting;
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Common\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoggerController extends Controller
{
    public function createLog(Request $request)
    {
        $data        = $request->data;
        $description = $request->description;
        $tabNane     = $request->tab_name;
        $user_id     = (int)$request->user_id;

        return Logger::create($data, $description, $tabNane, $user_id);
    }
}

<?php

namespace App\Http\Common;

use App\Models\Log;
use Carbon\Carbon;

class Logger
{
    public static function create(string $data, string $description, string $tab_name, int $user_id): int
    {
        $jsonData         = $data;
        $log              = new Log;
        $log->json_data   = $jsonData;
        $log->date        = Carbon::now();
        $log->description = $description;
        $log->tab_name    = $tab_name;
        $log->user_id     = $user_id;
        $res              = $log->save();
        return $res ? 1 : 0;
    }
}

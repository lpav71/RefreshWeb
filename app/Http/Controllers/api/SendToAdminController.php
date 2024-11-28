<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SendToAdmin;
use Illuminate\Http\Request;

class SendToAdminController extends Controller
{
    protected SendToAdmin $sendToAdmin;

    /**
     * @param SendToAdmin $sendToAdmin
     */
    public function __construct(SendToAdmin $sendToAdmin)
    {
        $this->sendToAdmin = $sendToAdmin;
    }

    public function getMessage(Request $request)
    {
        $club_id = $request->club_id;
        return $this->sendToAdmin->message($club_id);
    }
}


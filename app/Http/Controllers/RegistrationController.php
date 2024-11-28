<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function registration(Request $request)
    {
        $user   = Auth::user();
        $email  = $request->email;
        $idUser = $request->idUserSetting;

        if ($user != null) {
            $club_id = $user->club_id;
        } else {
            $club_id = null;
        }

        /* if (! $request->hasValidSignature()) {
             abort(401);
         }*/

        return view('registration.index', compact('club_id', 'email', 'idUser'));
    }
}

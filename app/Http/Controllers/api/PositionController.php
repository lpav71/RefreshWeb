<?php

namespace App\Http\Controllers\api;

use App\Http\Common\UserCommon;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use app\Http\Common;

class PositionController extends Controller
{
    public function getPermisions(Request $request)
    {
        $permissions = UserCommon::getPermissions($request->user_id, $request->club_id);
        return $permissions;
    }

    public function getUsers(Request $request)
    {
        $users = User::where('users.club_id', $request->club_id)->leftJoin('position', 'position.id', 'users.position_id')->get();
        return $users;
    }
    public function getPositions(Request $request){
        $positions = Position::where('club_id', $request->club_id)->get();
        return $positions;
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getGames()
    {
        $games = Game::where('club_id', 1)->where('map_comp_id',1)->orderBy('id')->get();
        return $games;
    }
    public function changeStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        if ($status == 'true')
            $status = true;
        else $status = false;
        $game = Game::find($id);
        $game->status = $status;
        $game->save();
    }
    public function searchGame(Request $request)
    {
        $gameName = $request->name;
        $games = Game::where('name', 'ILIKE', '%'.$gameName.'%')->orWhere('description', 'ILIKE', '%'.$gameName.'%')->get()->toArray();
        return $games;
    }
}

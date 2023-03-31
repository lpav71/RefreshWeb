<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getGames(Request $request)
    {
        $club_id = $request->club_id;
        $games = Game::where('club_id', $club_id)->where('map_comp_id',1)->orderBy('id')->get();
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
    public function getGameById(Request $request)
    {
        $id = $request->id;
        $game = Game::find($id);
        return $game;
    }
    public function saveGame(Request $request)
    {
        if ($request->id !== 'undefined') {
            $game = Game::find($request->id);
            $game->name = $request->name == 'null' ? null : $request->name;
            $game->link = $request->link == 'null' ? null : $request->link;
            $game->param = $request->param == 'null' ? null : $request->param;
            $game->steam_id = $request->steam_id == 'null' ? null : $request->steam_id;
            $game->club_account = $request->club_account == 'null' ? null : $request->club_account;
            $game->description = $request->description == 'null' ? null : $request->description;
            $game->icon = $request->icon == 'null' ? null : $request->icon;
        }
        else {
            $game = new Game;
            $game->club_id = $request->club_id;
            $game->map_comp_id = 1;
            $game->name = $request->name == 'undefined' ? null : $request->name;
            $game->link = $request->link == 'undefined' ? null : $request->link;
            $game->param = $request->param == 'undefined' ? null : $request->param;
            $game->steam_id = $request->steam_id == 'undefined' ? null : $request->steam_id;
            $game->club_account = $request->club_account == 'undefined' ? null : $request->club_account;
            $game->description = $request->description == 'undefined' ? null : $request->description;
            $game->icon = $request->icon == 'undefined' ? null : $request->icon;
        }
        $game->save();
    }
}

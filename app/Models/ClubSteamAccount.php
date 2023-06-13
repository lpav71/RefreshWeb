<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubSteamAccount extends Model
{
    use HasFactory;

    protected $table = 'club_steam_account';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    protected $fillable = [
        'summoner_id',
        'puuid',
        'game_name',
        'tag_line',
        'tier',
        'rank',
        'league_points',
        'wins',
        'losses',
        'profile_icon_id',
        'summoner_level',
    ];
}

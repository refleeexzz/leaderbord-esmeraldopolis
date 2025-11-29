<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    protected $riotService;

    public function __construct(\App\Services\RiotService $riotService)
    {
        $this->riotService = $riotService;
    }

    public function index()
    {
        // fetch all summoners ordered by league points
        $summoners = \App\Models\Summoner::orderBy('league_points', 'desc')->get();

        return view('leaderboard', compact('summoners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'riot_id' => 'required|string',
        ]);

        // split riot id into game name and tag line
        $parts = explode('#', $request->riot_id);
        if (count($parts) != 2) {
            return back()->withErrors(['msg' => 'invalid format. use name#tag']);
        }

        $gameName = $parts[0];
        $tagLine = $parts[1];

        // fetch account data from riot api
        $accountData = $this->riotService->getAccountByRiotId($gameName, $tagLine);

        if (!$accountData) {
            return back()->withErrors(['msg' => 'summoner not found']);
        }

        // fetch rank data
        $rankData = $this->riotService->getLeagueEntries($accountData['id']);

        // update or create summoner record
        \App\Models\Summoner::updateOrCreate(
            ['puuid' => $accountData['puuid']],
            [
                'summoner_id' => $accountData['id'],
                'game_name' => $accountData['gameName'],
                'tag_line' => $accountData['tagLine'],
                'profile_icon_id' => $accountData['profileIconId'],
                'summoner_level' => $accountData['summonerLevel'],
                'tier' => $rankData['tier'] ?? 'UNRANKED',
                'rank' => $rankData['rank'] ?? '',
                'league_points' => $rankData['leaguePoints'] ?? 0,
                'wins' => $rankData['wins'] ?? 0,
                'losses' => $rankData['losses'] ?? 0,
            ]
        );

        return back()->with('success', 'summoner added successfully');
    }
    
    public function updateAll()
    {
        $summoners = \App\Models\Summoner::all();
        
        foreach($summoners as $summoner) {
             // fetch latest rank data for each summoner
             $rankData = $this->riotService->getLeagueEntries($summoner->summoner_id);
             
             if ($rankData) {
                 $summoner->update([
                    'tier' => $rankData['tier'],
                    'rank' => $rankData['rank'],
                    'league_points' => $rankData['leaguePoints'],
                    'wins' => $rankData['wins'],
                    'losses' => $rankData['losses'],
                 ]);
             }
        }
        
        return back()->with('success', 'all summoners updated');
    }
}

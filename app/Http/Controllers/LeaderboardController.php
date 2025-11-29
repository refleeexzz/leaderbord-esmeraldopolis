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
        // fetch all summoners
        $summoners = \App\Models\Summoner::all();

        // Sort by Tier > Rank > LP
        $summoners = $summoners->sort(function ($a, $b) {
            $tiers = [
                'CHALLENGER' => 10, 'GRANDMASTER' => 9, 'MASTER' => 8,
                'DIAMOND' => 7, 'EMERALD' => 6, 'PLATINUM' => 5,
                'GOLD' => 4, 'SILVER' => 3, 'BRONZE' => 2, 'IRON' => 1, 'UNRANKED' => 0
            ];
            
            $ranks = ['I' => 4, 'II' => 3, 'III' => 2, 'IV' => 1, '' => 0];

            $tierA = $tiers[strtoupper($a->tier)] ?? 0;
            $tierB = $tiers[strtoupper($b->tier)] ?? 0;

            if ($tierA !== $tierB) {
                return $tierB <=> $tierA; // Descending
            }

            $rankA = $ranks[$a->rank] ?? 0;
            $rankB = $ranks[$b->rank] ?? 0;

            if ($rankA !== $rankB) {
                return $rankB <=> $rankA; // Descending
            }

            return $b->league_points <=> $a->league_points; // Descending
        })->values();

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

        $summonerId = $accountData['id'] ?? null;
        $rankData = [];

        if ($summonerId) {
            // fetch rank data
            $rankData = $this->riotService->getLeagueEntries($summonerId) ?? [];
        } else {
            // fallback to puuid if summoner id is missing
            $rankData = $this->riotService->getLeagueEntriesByPuuid($accountData['puuid']) ?? [];
        }

        // update or create summoner record
        \App\Models\Summoner::updateOrCreate(
            ['puuid' => $accountData['puuid']],
            [
                'summoner_id' => $summonerId,
                'game_name' => $accountData['gameName'],
                'tag_line' => $accountData['tagLine'],
                'profile_icon_id' => $accountData['profileIconId'] ?? null,
                'summoner_level' => $accountData['summonerLevel'] ?? 0,
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
             if ($summoner->summoner_id) {
                 $rankData = $this->riotService->getLeagueEntries($summoner->summoner_id);
             } else {
                 $rankData = $this->riotService->getLeagueEntriesByPuuid($summoner->puuid);
             }
             
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

    public function update(Request $request, $id)
    {
        $summoner = \App\Models\Summoner::findOrFail($id);
        
        // fetch latest rank data
        if ($summoner->summoner_id) {
            $rankData = $this->riotService->getLeagueEntries($summoner->summoner_id);
        } else {
            $rankData = $this->riotService->getLeagueEntriesByPuuid($summoner->puuid);
        }
        
        if ($rankData) {
            $summoner->update([
               'tier' => $rankData['tier'],
               'rank' => $rankData['rank'],
               'league_points' => $rankData['leaguePoints'],
               'wins' => $rankData['wins'],
               'losses' => $rankData['losses'],
            ]);
            return back()->with('success', "updated {$summoner->game_name}");
        }

        return back()->withErrors(['msg' => 'could not update summoner']);
    }

    public function destroy($id)
    {
        $summoner = \App\Models\Summoner::findOrFail($id);
        $summoner->delete();
        return back()->with('success', 'summoner removed successfully');
    }

    public function history($id)
    {
        $summoner = \App\Models\Summoner::findOrFail($id);
        $matchIds = $this->riotService->getMatchIds($summoner->puuid, 3); // Limit to 3 for speed
        
        $matches = [];
        foreach($matchIds as $matchId) {
            $details = $this->riotService->getMatchDetails($matchId);
            if ($details) {
                $matches[] = $this->formatMatchData($details, $summoner->puuid);
            }
        }
        
        return view('partials.history', compact('matches'));
    }

    private function formatMatchData($details, $puuid)
    {
        // Extract relevant data for the specific summoner
        $participant = collect($details['info']['participants'])->firstWhere('puuid', $puuid);
        
        // Extract all participants for the detailed view
        $allParticipants = collect($details['info']['participants'])->map(function($p) {
            return [
                'puuid' => $p['puuid'],
                'riotIdGameName' => $p['riotIdGameName'] ?? $p['summonerName'],
                'riotIdTagLine' => $p['riotIdTagLine'] ?? '',
                'championName' => $p['championName'],
                'kills' => $p['kills'],
                'deaths' => $p['deaths'],
                'assists' => $p['assists'],
                'win' => $p['win'],
                'item0' => $p['item0'],
                'item1' => $p['item1'],
                'item2' => $p['item2'],
                'item3' => $p['item3'],
                'item4' => $p['item4'],
                'item5' => $p['item5'],
                'item6' => $p['item6'],
                'totalMinionsKilled' => $p['totalMinionsKilled'] + $p['neutralMinionsKilled'],
                'teamId' => $p['teamId'],
            ];
        });

        return [
            'matchId' => $details['metadata']['matchId'],
            'championName' => $participant['championName'],
            'kills' => $participant['kills'],
            'deaths' => $participant['deaths'],
            'assists' => $participant['assists'],
            'win' => $participant['win'],
            'item0' => $participant['item0'],
            'item1' => $participant['item1'],
            'item2' => $participant['item2'],
            'item3' => $participant['item3'],
            'item4' => $participant['item4'],
            'item5' => $participant['item5'],
            'item6' => $participant['item6'],
            'totalMinionsKilled' => $participant['totalMinionsKilled'] + $participant['neutralMinionsKilled'],
            'gameDuration' => $details['info']['gameDuration'],
            'gameMode' => $details['info']['gameMode'],
            'gameCreation' => $details['info']['gameCreation'],
            'participants' => $allParticipants,
        ];
    }
}

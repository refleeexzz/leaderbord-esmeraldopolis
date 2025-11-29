<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RiotService
{
    protected $apiKey;
    protected $region = 'br1'; // region for summoner/league data
    protected $americas = 'americas'; // region for account v1 (riot id)

    public function __construct()
    {
        $this->apiKey = env('RIOT_API_KEY');
    }

    /**
     * fetch puuid and summoner id by riot id (name#tag)
     */
    public function getAccountByRiotId($gameName, $tagLine)
    {
        // 1. get puuid via account-v1 (americas cluster covers br1)
        // url encoding is crucial for names with special characters
        $gameName = rawurlencode($gameName);
        $tagLine = rawurlencode($tagLine);
        
        $url = "https://{$this->americas}.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$gameName}/{$tagLine}";
        
        $response = Http::withHeader('X-Riot-Token', $this->apiKey)->get($url);

        if ($response->failed()) {
            Log::error("error fetching riot account [{$gameName}#{$tagLine}]: " . $response->body());
            return null;
        }

        $accountData = $response->json();
        $puuid = $accountData['puuid'];

        // 2. get summoner id via summoner-v4 using puuid (br1 server)
        $summonerUrl = "https://{$this->region}.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/{$puuid}";
        
        $summonerResponse = Http::withHeader('X-Riot-Token', $this->apiKey)->get($summonerUrl);

        if ($summonerResponse->failed()) {
            Log::error("error fetching summoner v4 [puuid: {$puuid}]: " . $summonerResponse->body());
            return null;
        }

        return array_merge($accountData, $summonerResponse->json());
    }

    /**
     * fetch rank (tier, lp, wins) by summoner id
     */
    public function getLeagueEntries($summonerId)
    {
        $response = Http::withHeader('X-Riot-Token', $this->apiKey)
            ->get("https://{$this->region}.api.riotgames.com/lol/league/v4/entries/by-summoner/{$summonerId}");

        if ($response->failed()) {
            return [];
        }

        return $this->filterSoloQueue($response->json());
    }

    /**
     * fetch rank by puuid (fallback)
     */
    public function getLeagueEntriesByPuuid($puuid)
    {
        $response = Http::withHeader('X-Riot-Token', $this->apiKey)
            ->get("https://{$this->region}.api.riotgames.com/lol/league/v4/entries/by-puuid/{$puuid}");

        if ($response->failed()) {
            return [];
        }

        return $this->filterSoloQueue($response->json());
    }

    public function getMatchIds($puuid, $count = 5)
    {
        $url = "https://{$this->americas}.api.riotgames.com/lol/match/v5/matches/by-puuid/{$puuid}/ids?start=0&count={$count}";
        $response = Http::withHeader('X-Riot-Token', $this->apiKey)->get($url);
        
        if ($response->failed()) {
            return [];
        }
        
        return $response->json();
    }

    public function getMatchDetails($matchId)
    {
        $url = "https://{$this->americas}.api.riotgames.com/lol/match/v5/matches/{$matchId}";
        $response = Http::withHeader('X-Riot-Token', $this->apiKey)->get($url);
        
        if ($response->failed()) {
            return null;
        }
        
        return $response->json();
    }

    private function filterSoloQueue($entries)
    {
        foreach ($entries as $entry) {
            if ($entry['queueType'] === 'RANKED_SOLO_5x5') {
                return $entry;
            }
        }
        return null; // unranked
    }
}

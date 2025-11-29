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
        // 1. get puuid via account-v1
        $response = Http::withHeader('X-Riot-Token', $this->apiKey)
            ->get("https://{$this->americas}.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$gameName}/{$tagLine}");

        if ($response->failed()) {
            Log::error('error fetching riot account: ' . $response->body());
            return null;
        }

        $accountData = $response->json();
        $puuid = $accountData['puuid'];

        // 2. get summoner id via summoner-v4 using puuid
        $summonerResponse = Http::withHeader('X-Riot-Token', $this->apiKey)
            ->get("https://{$this->region}.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/{$puuid}");

        if ($summonerResponse->failed()) {
            Log::error('error fetching summoner v4: ' . $summonerResponse->body());
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

        // filter only solo/duo queue
        $entries = $response->json();
        foreach ($entries as $entry) {
            if ($entry['queueType'] === 'RANKED_SOLO_5x5') {
                return $entry;
            }
        }

        return null; // unranked
    }
}

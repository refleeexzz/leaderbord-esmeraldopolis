@foreach($matches as $match)
    <div class="mb-2">
        <!-- Main Row (Clickable) -->
        <div onclick="document.getElementById('details-{{ $match['matchId'] }}').classList.toggle('hidden')" 
             class="cursor-pointer hover:bg-opacity-80 transition-all flex items-center justify-between p-3 rounded-t border-l-4 {{ $match['win'] ? 'bg-green-900/20 border-green-500' : 'bg-red-900/20 border-red-500' }} {{ $match['win'] ? 'border-b border-green-900/30' : 'border-b border-red-900/30' }}">
            
            <!-- Champion & Result -->
            <div class="flex items-center gap-3">
                <img src="https://ddragon.leagueoflegends.com/cdn/14.23.1/img/champion/{{ $match['championName'] }}.png" 
                     alt="{{ $match['championName'] }}" 
                     class="w-10 h-10 rounded-full border border-gray-600">
                <div>
                    <div class="font-bold text-sm {{ $match['win'] ? 'text-green-400' : 'text-red-400' }}">
                        {{ $match['win'] ? 'Vitória' : 'Derrota' }}
                    </div>
                    <div class="text-xs text-gray-500">{{ gmdate("i:s", $match['gameDuration']) }}</div>
                </div>
            </div>

            <!-- KDA -->
            <div class="text-center">
                <div class="font-bold text-white text-sm">
                    {{ $match['kills'] }} / <span class="text-red-400">{{ $match['deaths'] }}</span> / {{ $match['assists'] }}
                </div>
                <div class="text-xs text-gray-500">
                    @php
                        $kda = $match['deaths'] > 0 ? ($match['kills'] + $match['assists']) / $match['deaths'] : ($match['kills'] + $match['assists']);
                    @endphp
                    {{ number_format($kda, 2) }} KDA
                </div>
            </div>

            <!-- CS -->
            <div class="text-center hidden md:block">
                <div class="text-xs text-gray-400">CS {{ $match['totalMinionsKilled'] }}</div>
                <div class="text-[10px] text-gray-600">
                    {{ number_format($match['totalMinionsKilled'] / ($match['gameDuration'] / 60), 1) }}/min
                </div>
            </div>

            <!-- Items -->
            <div class="flex gap-1">
                @foreach(range(0, 5) as $i)
                    @if($match['item'.$i])
                        <div class="w-6 h-6 rounded bg-gray-800 border border-gray-700 overflow-hidden">
                            <img src="https://ddragon.leagueoflegends.com/cdn/14.23.1/img/item/{{ $match['item'.$i] }}.png" 
                                 class="w-full h-full" alt="Item" onerror="this.style.display='none'">
                        </div>
                    @else
                        <div class="w-6 h-6 rounded bg-gray-800/50 border border-gray-700"></div>
                    @endif
                @endforeach
                <!-- Trinket -->
                @if($match['item6'])
                     <div class="w-6 h-6 rounded-full bg-gray-800 border border-gray-700 ml-1 overflow-hidden">
                        <img src="https://ddragon.leagueoflegends.com/cdn/14.23.1/img/item/{{ $match['item6'] }}.png" 
                             class="w-full h-full" alt="Trinket" onerror="this.style.display='none'">
                     </div>
                @endif
            </div>
            
            <!-- Arrow -->
            <div class="text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

        </div>

        <!-- Detailed View (Hidden) -->
        <div id="details-{{ $match['matchId'] }}" class="hidden bg-[#18181b] rounded-b border-x border-b border-gray-700 p-2 text-xs">
            
            <!-- Header -->
            <div class="grid grid-cols-12 text-gray-500 px-2 mb-1 uppercase tracking-wider text-[10px]">
                <div class="col-span-4">Campeão / Jogador</div>
                <div class="col-span-2 text-center">KDA</div>
                <div class="col-span-2 text-center">CS</div>
                <div class="col-span-4">Itens</div>
            </div>

            @foreach([100, 200] as $teamId)
                <div class="mb-2 {{ $teamId == 200 ? 'mt-2 pt-2 border-t border-gray-800' : '' }}">
                    @foreach($match['participants'] as $p)
                        @if($p['teamId'] == $teamId)
                            <div class="grid grid-cols-12 items-center py-1 hover:bg-white/5 rounded px-2 {{ $p['win'] ? 'bg-green-500/5' : 'bg-red-500/5' }}">
                                
                                <!-- Champion & Name -->
                                <div class="col-span-4 flex items-center gap-2 overflow-hidden">
                                    <img src="https://ddragon.leagueoflegends.com/cdn/14.23.1/img/champion/{{ $p['championName'] }}.png" 
                                         class="w-6 h-6 rounded-full border border-gray-600" alt="{{ $p['championName'] }}">
                                    <div class="truncate">
                                        <div class="text-white font-medium truncate" title="{{ $p['riotIdGameName'] }}#{{ $p['riotIdTagLine'] }}">
                                            {{ $p['riotIdGameName'] }} <span class="text-gray-500">#{{ $p['riotIdTagLine'] }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- KDA -->
                                <div class="col-span-2 text-center">
                                    <span class="text-gray-300">{{ $p['kills'] }}/{{ $p['deaths'] }}/{{ $p['assists'] }}</span>
                                </div>

                                <!-- CS -->
                                <div class="col-span-2 text-center text-gray-400">
                                    {{ $p['totalMinionsKilled'] }}
                                </div>

                                <!-- Items -->
                                <div class="col-span-4 flex gap-1 justify-end">
                                    @foreach(range(0, 5) as $i)
                                        @if($p['item'.$i])
                                            <div class="w-5 h-5 rounded bg-gray-800 border border-gray-700 overflow-hidden">
                                                <img src="https://ddragon.leagueoflegends.com/cdn/14.23.1/img/item/{{ $p['item'.$i] }}.png" 
                                                     class="w-full h-full" alt="Item" onerror="this.style.display='none'">
                                            </div>
                                        @else
                                            <div class="w-5 h-5 rounded bg-gray-800/30 border border-gray-700/50"></div>
                                        @endif
                                    @endforeach
                                    <!-- Trinket Detail -->
                                    @if($p['item6'])
                                        <div class="w-5 h-5 rounded-full bg-gray-800 border border-gray-700 ml-1 overflow-hidden">
                                            <img src="https://ddragon.leagueoflegends.com/cdn/14.23.1/img/item/{{ $p['item6'] }}.png" 
                                                 class="w-full h-full" alt="Trinket" onerror="this.style.display='none'">
                                        </div>
                                    @else
                                         <div class="w-5 h-5 rounded-full bg-gray-800/30 border border-gray-700/50 ml-1"></div>
                                    @endif
                                </div>

                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endforeach
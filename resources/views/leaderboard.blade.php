<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard Esmeraldopolis</title>
    <link rel="icon" type="image/png" href="{{ asset('img/75202705-b62e-4082-8715-f43f102c6bc5.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-discord-dark { background-color: #313338; }
        .bg-discord-card { background-color: #2b2d31; }
        .bg-discord-hover { background-color: #3f4147; }
    </style>
    <script>
        // Auto-refresh every 2 minutes (120000 ms)
        setTimeout(function(){
           window.location.reload(1);
        }, 120000);
    </script>
</head>
<body class="bg-[#1e1f22] text-gray-100 min-h-screen flex justify-center p-4 md:p-8 bg-cover bg-center bg-fixed bg-no-repeat relative" style="background-image: url('{{ asset('img/image.png') }}');">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/90 z-0 pointer-events-none"></div>

    <div class="w-full max-w-6xl z-10 relative">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-center justify-between bg-black/30 backdrop-blur-md p-6 rounded-xl shadow-2xl mb-8 border border-white/10">
            <div class="flex items-center gap-6 mb-4 md:mb-0">
                <div class="relative">
                    <img src="{{ asset('img/75202705-b62e-4082-8715-f43f102c6bc5.png') }}" 
                         alt="Logo" 
                         class="w-24 h-24 rounded-2xl shadow-lg object-cover border-4 border-[#1e1f22]">
                    <div class="absolute -bottom-2 -right-2 bg-[#10b981] text-white text-xs font-bold px-2 py-1 rounded-full border-2 border-[#2b2d31]">
                        BR
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight">Esmeraldopolis</h1>
                    <p class="text-sm text-gray-400 font-medium uppercase tracking-wider">RANKING DOS ESMERALDAS </p>
                </div>
            </div>
            
            <div class="flex flex-col items-end gap-3">
                 <!-- Stats -->
                 <div class="flex items-center gap-4">
                     <div class="text-right">
                         <div class="text-xs text-gray-500 font-bold uppercase">Jogadores</div>
                         <div class="text-xl font-bold text-white">{{ $summoners->count() }}</div>
                     </div>
                     <div class="h-8 w-px bg-gray-700"></div>
                     <div class="text-right">
                         
                     </div>
                 </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex justify-between items-center mb-4 px-2">
            <div class="flex gap-2">
                <span class="bg-[#10b981] text-white px-4 py-1 rounded-full text-xs font-bold shadow-lg shadow-emerald-900/20">Solo/Duo</span>
                <span class="bg-[#2b2d31] text-gray-500 px-4 py-1 rounded-full text-xs font-bold border border-gray-700 opacity-50 cursor-not-allowed">Flex</span>
            </div>
            <div class="flex gap-3 text-xs font-bold text-gray-400">
                 <a href="{{ route('admin.index') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                    </svg>
                    ADMIN
                 </a>
                 <form action="{{ route('leaderboard.updateAll') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-white transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        ATUALIZAR
                    </button>
                </form>
            </div>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="bg-green-500/10 text-green-400 p-3 rounded-lg mb-6 text-sm font-medium border border-green-500/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/10 text-red-400 p-3 rounded-lg mb-6 text-sm font-medium border border-red-500/20">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Leaderboard List -->
        <div class="flex flex-col gap-2">
            
            <!-- Header Row -->
            <div class="grid grid-cols-12 gap-4 px-6 py-3 text-xs font-bold uppercase text-gray-500 tracking-wider">
                <div class="col-span-1">#</div>
                <div class="col-span-5">Invocador</div>
                <div class="col-span-3">Elo</div>
                <div class="col-span-2 text-center">Winrate</div>
                <div class="col-span-1 text-right"></div>
            </div>

            <!-- Rows -->
            @foreach($summoners as $index => $summoner)
                <div class="relative group bg-black/30 hover:bg-black/50 backdrop-blur-sm rounded-lg py-6 px-6 transition-all duration-200 shadow-md hover:shadow-xl border border-white/5 hover:border-[#10b981]/50">
                    
                    <div class="grid grid-cols-12 gap-4 items-center">
                        
                        <!-- Rank -->
                        <div class="col-span-1">
                            <span class="text-lg font-bold {{ $index < 3 ? 'text-[#e0c209]' : 'text-gray-500' }}">
                                {{ $index + 1 }}
                            </span>
                        </div>
                        
                        <!-- Summoner -->
                        <div class="col-span-5 flex items-center gap-4">
                            <div class="relative">
                                @if($summoner->profile_icon_id)
                                    <img src="https://ddragon.leagueoflegends.com/cdn/14.23.1/img/profileicon/{{ $summoner->profile_icon_id }}.png" 
                                         alt="Icon" class="w-14 h-14 rounded-full bg-gray-800 border-2 border-[#1e1f22]">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-gray-700 border-2 border-[#1e1f22]"></div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 bg-[#2b2d31] rounded-full p-0.5">
                                    <div class="w-4 h-4 rounded-full {{ $summoner->hot_streak ? 'bg-red-500 animate-pulse' : 'bg-gray-500' }}" title="Hot Streak"></div>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <div class="font-bold text-white text-lg truncate hover:text-[#10b981] transition-colors">
                                    <a href="https://www.op.gg/summoners/br/{{ $summoner->game_name }}-{{ $summoner->tag_line }}" target="_blank">
                                        {{ $summoner->game_name }}
                                    </a>
                                </div>
                                <div class="text-[10px] text-gray-500 font-bold">#{{ $summoner->tag_line }}</div>
                            </div>
                        </div>

                        <!-- Tier (With Image) -->
                        <div class="col-span-3 flex items-center gap-3">
                            @php
                                $tier = strtolower($summoner->tier);
                                // Use OP.GG static assets which are reliable
                                $iconUrl = match($tier) {
                                    'iron' => 'https://opgg-static.akamaized.net/images/medals_new/iron.png',
                                    'bronze' => 'https://opgg-static.akamaized.net/images/medals_new/bronze.png',
                                    'silver' => 'https://opgg-static.akamaized.net/images/medals_new/silver.png',
                                    'gold' => 'https://opgg-static.akamaized.net/images/medals_new/gold.png',
                                    'platinum' => 'https://opgg-static.akamaized.net/images/medals_new/platinum.png',
                                    'emerald' => 'https://opgg-static.akamaized.net/images/medals_new/emerald.png',
                                    'diamond' => 'https://opgg-static.akamaized.net/images/medals_new/diamond.png',
                                    'master' => 'https://opgg-static.akamaized.net/images/medals_new/master.png',
                                    'grandmaster' => 'https://opgg-static.akamaized.net/images/medals_new/grandmaster.png',
                                    'challenger' => 'https://opgg-static.akamaized.net/images/medals_new/challenger.png',
                                    default => 'https://raw.communitydragon.org/latest/plugins/rcp-fe-lol-shared-components/global/default/images/unranked.png'
                                };
                            @endphp
                            <img src="{{ $iconUrl }}" 
                                 alt="{{ $summoner->tier ?? 'Unranked' }}" 
                                 class="w-14 h-14 object-contain"
                                 onerror="this.src='https://raw.communitydragon.org/latest/plugins/rcp-fe-lol-shared-components/global/default/images/unranked.png'">
                            
                            <div class="flex flex-col">
                                <span class="font-bold text-base text-gray-200">{{ $summoner->tier ? ucfirst(strtolower($summoner->tier)) . ' ' . $summoner->rank : 'Unranked' }}</span>
                                <span class="text-xs text-gray-400 font-mono">{{ $summoner->league_points }} PDL</span>
                            </div>
                        </div>

                        <!-- Winrate -->
                        <div class="col-span-2 flex flex-col items-center justify-center">
                            @php
                                $total = $summoner->wins + $summoner->losses;
                                $wr = $total > 0 ? round(($summoner->wins / $total) * 100) : 0;
                                $wrColor = $wr >= 50 ? 'bg-[#10b981]' : 'bg-red-500';
                                $wrText = $wr >= 50 ? 'text-[#10b981]' : 'text-red-400';
                            @endphp
                            <div class="text-xs font-bold {{ $wrText }} mb-1">{{ $wr }}%</div>
                            <div class="w-full bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                <div class="{{ $wrColor }} h-1.5 rounded-full" style="width: {{ $wr }}%"></div>
                            </div>
                            <div class="text-[9px] text-gray-500 mt-1">{{ $summoner->wins }}V - {{ $summoner->losses }}D</div>
                        </div>

                        <!-- Actions -->
                        <div class="col-span-1 text-right flex flex-col gap-2 items-end">
                            <form action="{{ route('leaderboard.update', $summoner->id) }}" method="POST" class="inline-block opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                @csrf
                                <button type="submit" class="bg-[#404249] hover:bg-[#10b981] text-white p-2 rounded-md transition-colors shadow-lg" title="Atualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </button>
                            </form>
                            
                            <button onclick="toggleHistory({{ $summoner->id }})" class="bg-[#404249] hover:bg-[#10b981] text-white p-2 rounded-md transition-colors shadow-lg opacity-0 group-hover:opacity-100" title="Ver Partidas">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>

                            @if(session('is_admin'))
                                <form action="{{ route('leaderboard.destroy', $summoner->id) }}" method="POST" class="inline-block opacity-0 group-hover:opacity-100 transition-opacity duration-200" onsubmit="return confirm('Tem certeza que deseja remover este jogador?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-[#404249] hover:bg-red-500 text-white p-2 rounded-md transition-colors shadow-lg" title="Remover">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                    
                    <!-- History Container -->
                    <div id="history-wrapper-{{ $summoner->id }}" class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-500 ease-out">
                        <div class="overflow-hidden">
                            <div id="history-content-{{ $summoner->id }}" class="mt-4 border-t border-gray-700 pt-4 opacity-0 transition-opacity duration-500">
                                <div class="text-center text-gray-500 text-xs animate-pulse">Carregando partidas...</div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8 text-gray-600 text-[10px] uppercase tracking-widest">
            Esmeraldopolis &copy; {{ date('Y') }}
        </div>

    </div>

    <script>
        function toggleHistory(id) {
            const wrapper = document.getElementById(`history-wrapper-${id}`);
            const content = document.getElementById(`history-content-${id}`);
            
            const isClosed = wrapper.classList.contains('grid-rows-[0fr]');
            
            if (isClosed) {
                // Open
                wrapper.classList.remove('grid-rows-[0fr]');
                wrapper.classList.add('grid-rows-[1fr]');
                
                // Fade in content
                setTimeout(() => {
                    content.classList.remove('opacity-0');
                }, 50);

                // Only fetch if empty (not already loaded)
                if (content.innerHTML.includes('Carregando')) {
                    fetch(`/summoner/${id}/history`)
                        .then(response => response.text())
                        .then(html => {
                            content.innerHTML = html;
                        })
                        .catch(err => {
                            content.innerHTML = '<div class="text-red-400 text-xs text-center">Erro ao carregar partidas.</div>';
                        });
                }
            } else {
                // Close
                content.classList.add('opacity-0');
                wrapper.classList.remove('grid-rows-[1fr]');
                wrapper.classList.add('grid-rows-[0fr]');
            }
        }

        function toggleMatchDetails(matchId) {
            const wrapper = document.getElementById(`details-wrapper-${matchId}`);
            const content = document.getElementById(`details-content-${matchId}`);
            const arrow = document.getElementById(`arrow-${matchId}`);
            
            const isClosed = wrapper.classList.contains('grid-rows-[0fr]');
            
            if (isClosed) {
                // Open
                wrapper.classList.remove('grid-rows-[0fr]');
                wrapper.classList.add('grid-rows-[1fr]');
                content.classList.remove('opacity-0');
                if(arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                // Close
                content.classList.add('opacity-0');
                wrapper.classList.remove('grid-rows-[1fr]');
                wrapper.classList.add('grid-rows-[0fr]');
                if(arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</body>
</html>

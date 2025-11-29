<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Esmeraldopolis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-space-dark { background-color: #0a0e17; }
        .bg-space-blue { background-color: #1a2639; }
        .text-cyan-glow { color: #00f0ff; text-shadow: 0 0 10px #00f0ff; }
        .btn-yellow { background-color: #f5d300; color: black; }
        .btn-yellow:hover { background-color: #d4b700; }
    </style>
</head>
<body class="bg-[#313338] text-[#dbdee1] font-sans min-h-screen flex justify-center p-4">

    <div class="w-full max-w-2xl">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-white tracking-wide">Painel Admin</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-red-400 hover:text-red-300 font-bold uppercase tracking-wider">Sair</button>
            </form>
        </div>

        <!-- Add Player Form -->
        <div class="bg-[#2b2d31] p-6 rounded-md shadow-md mb-6">
            <h2 class="text-sm font-bold mb-4 text-gray-400 uppercase tracking-wider">Adicionar Novo Jogador</h2>
            
            @if(session('success'))
                <div class="bg-green-900/50 text-green-200 p-3 rounded mb-4 text-sm border border-green-900">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-900/50 text-red-200 p-3 rounded mb-4 text-sm border border-red-900">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('leaderboard.store') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="riot_id" placeholder="Nome#TAG" required 
                    class="flex-1 bg-[#1e1f22] text-white px-4 py-2 rounded text-sm border border-[#1e1f22] focus:outline-none focus:border-[#10b981] placeholder-gray-600">
                <button type="submit" class="bg-[#10b981] hover:bg-[#059669] text-white font-bold px-6 py-2 rounded text-sm transition-colors">
                    Adicionar
                </button>
            </form>
        </div>

        <div class="text-center">
            <a href="{{ route('leaderboard.index') }}" class="text-gray-500 hover:text-white text-xs font-bold uppercase tracking-wider transition-colors">Voltar para Leaderboard</a>
        </div>

    </div>
</body>
</html>

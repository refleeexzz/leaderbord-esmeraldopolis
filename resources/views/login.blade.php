<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Esmeraldopolis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-space-dark { background-color: #0a0e17; }
        .bg-space-blue { background-color: #1a2639; }
        .text-cyan-glow { color: #00f0ff; text-shadow: 0 0 10px #00f0ff; }
        .btn-yellow { background-color: #f5d300; color: black; }
        .btn-yellow:hover { background-color: #d4b700; }
    </style>
</head>
<body class="bg-[#313338] text-[#dbdee1] font-sans min-h-screen flex items-center justify-center p-4">

    <div class="bg-[#2b2d31] p-8 rounded-md shadow-lg w-full max-w-sm">
        <h1 class="text-xl font-bold text-white mb-6 text-center tracking-wide">Acesso Admin</h1>

        @if($errors->any())
            <div class="bg-red-900/50 text-red-200 p-3 rounded mb-4 text-sm border border-red-900 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-400 mb-1 uppercase tracking-wider">Usuário</label>
                <input type="text" name="username" required 
                    class="w-full bg-[#1e1f22] text-white px-3 py-2 rounded text-sm border border-[#1e1f22] focus:outline-none focus:border-[#10b981]">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 mb-1 uppercase tracking-wider">Senha</label>
                <input type="password" name="password" required 
                    class="w-full bg-[#1e1f22] text-white px-3 py-2 rounded text-sm border border-[#1e1f22] focus:outline-none focus:border-[#10b981]">
            </div>

            <button type="submit" class="bg-[#10b981] hover:bg-[#059669] text-white font-bold py-2 rounded text-sm transition-colors mt-2">
                Entrar
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="{{ route('leaderboard.index') }}" class="text-gray-500 hover:text-white text-xs font-bold uppercase tracking-wider transition-colors">Voltar para Leaderboard</a>
        </div>
    </div>

</body>
</html>

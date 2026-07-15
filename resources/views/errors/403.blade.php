<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak �?Stockify</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono-tag { font-family: 'IBM Plex Mono', monospace; }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70% { transform: translateX(-6px); }
            20%, 40%, 60%, 80% { transform: translateX(6px); }
            90% { transform: translateX(-3px); }
        }
        .shake-icon {
            animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
            animation-delay: 0.3s;
        }

        @keyframes pulse-ring {
            0%   { transform: scale(0.9); opacity: 0.6; }
            70%  { transform: scale(1.4); opacity: 0; }
            100% { transform: scale(1.4); opacity: 0; }
        }
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fade-up 0.5s ease-out both; }
        .fade-up-delay-1 { animation-delay: 0.15s; }
        .fade-up-delay-2 { animation-delay: 0.25s; }
        .fade-up-delay-3 { animation-delay: 0.35s; }
    </style>
</head>
<body class="min-h-screen bg-[#0B1220] flex items-center justify-center p-6 overflow-hidden relative">

    {{-- Ambient background grid pattern --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 48px 48px;"></div>

    <div class="relative z-10 w-full max-w-md text-center">

        {{-- Icon dengan efek pulse ring + shake --}}
        <div class="relative w-20 h-20 mx-auto mb-8 flex items-center justify-center">
            <div class="pulse-ring absolute inset-0 rounded-full bg-red-500/20"></div>
            <div class="shake-icon relative w-20 h-20 rounded-2xl bg-red-500/10 border border-red-500/30 flex items-center justify-center">
                <svg class="w-9 h-9 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
        </div>

        <p class="fade-up font-mono-tag text-[11px] text-red-400 tracking-wide mb-3">ERROR 403 · AKSES DIBATASI</p>

        <h1 class="fade-up fade-up-delay-1 font-display text-2xl sm:text-3xl font-semibold text-white mb-3 leading-snug">
            {{ $exception->getMessage() ?: 'Anda tidak memiliki akses ke halaman ini' }}
        </h1>

        <p class="fade-up fade-up-delay-2 text-slate-400 text-sm mb-8 max-w-sm mx-auto leading-relaxed">
            Halaman ini khusus untuk role tertentu. Kalau menurut Anda ini kekeliruan, hubungi Admin untuk menyesuaikan hak akses akun Anda.
        </p>

        <div class="fade-up fade-up-delay-3 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('dashboard') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Dashboard
            </a>
            <button onclick="window.history.back()"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 text-sm font-medium px-5 py-2.5 rounded-lg transition">
                Halaman Sebelumnya
            </button>
        </div>

        <p class="fade-up fade-up-delay-3 font-mono-tag text-center text-[11px] text-slate-600 mt-12 tracking-wide">
            STOCKIFY WMS · AKSES DIKELOLA PER ROLE
        </p>
    </div>

</body>
</html>

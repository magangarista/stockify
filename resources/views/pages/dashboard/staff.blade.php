@extends('layouts.dashboard')
@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .row-fade-in { animation: fadeInUp 0.35s ease-out both; }
</style>

<div class="min-h-full p-4 sm:p-6">

    @php
        $hour = (int) date('H');
        $greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
        $totalTasks = $pendingIn->count() + $pendingOut->count();
    @endphp

    {{-- Header banner --}}
    <div class="mb-6 rounded-2xl bg-[#0B1220] px-6 py-7 sm:px-8 shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute left-1/3 -bottom-10 w-32 h-32 bg-emerald-400/10 rounded-full blur-2xl"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
            <div>
                <p class="text-[11px] font-semibold text-blue-400 tracking-widest uppercase mb-1.5">{{ $greeting }}</p>
                <h1 class="text-2xl font-bold text-white">{{ auth()->user()->name }}</h1>
                <p class="text-sm text-slate-400 mt-1">
                    @if($totalTasks > 0)
                        Ada <span class="font-semibold text-white">{{ $totalTasks }} tugas</span> yang menunggu diproses hari ini.
                    @else
                        Semua tugas sudah beres. Kerja bagus!
                    @endif
                </p>
            </div>

            {{-- Ringkasan --}}
            <div class="flex gap-3">
                <div class="bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-center min-w-[84px]">
                    <p class="text-xl font-bold text-white">{{ $pendingIn->count() }}</p>
                    <p class="text-[10px] font-medium text-emerald-400 uppercase tracking-wide mt-0.5">Masuk</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-center min-w-[84px]">
                    <p class="text-xl font-bold text-white">{{ $pendingOut->count() }}</p>
                    <p class="text-[10px] font-medium text-red-400 uppercase tracking-wide mt-0.5">Keluar</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-5 flex items-center gap-2.5 px-4 py-3 text-sm text-emerald-400 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-center gap-2.5 px-4 py-3 text-sm text-red-400 rounded-xl bg-red-500/10 border border-red-500/20">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12V16.5zm9-4.5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if($totalTasks === 0)
    {{-- Semua tugas selesai --}}
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl py-16 flex flex-col items-center justify-center text-center">
        <div class="w-14 h-14 rounded-full bg-emerald-500/10 flex items-center justify-center mb-4">
            <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-base font-semibold text-white">Tidak ada tugas tersisa</p>
        <p class="text-sm text-slate-500 mt-1">Semua barang masuk dan keluar sudah dikonfirmasi.</p>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Barang Masuk --}}
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="px-5 py-4 flex items-center gap-3 border-b border-white/5">
                <div class="w-9 h-9 rounded-lg bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-6 6m6-6l6 6"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Barang Masuk Perlu Diperiksa</h2>
                    <p class="text-xs text-slate-500">{{ $pendingIn->count() }} tugas menunggu</p>
                </div>
            </div>
            <div class="p-3">
                @forelse($pendingIn as $trx)
                    @php
                        $isLate = $trx->date->isPast() && !$trx->date->isToday();
                        $isToday = $trx->date->isToday();
                    @endphp
                    <div class="row-fade-in flex items-center justify-between gap-3 p-3 rounded-xl hover:bg-emerald-500/[0.06] transition-colors" style="animation-delay: {{ $loop->index * 40 }}ms">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($trx->product && $trx->product->image)
                                <img src="{{ asset('storage/'.$trx->product->image) }}" class="w-11 h-11 rounded-lg object-cover flex-shrink-0 border border-white/10">
                            @else
                                <div class="w-11 h-11 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-semibold text-white truncate">{{ $trx->product->name ?? '-' }}</p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <p class="text-xs text-slate-500">{{ $trx->quantity }} unit &middot; {{ $trx->date->format('d M Y') }}</p>
                                    @if($isLate)
                                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-red-500/10 text-red-400">Terlambat</span>
                                    @elseif($isToday)
                                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-400">Hari ini</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('stock.in.confirm', $trx->id) }}" method="POST" onsubmit="return confirm('Konfirmasi barang masuk ini sudah diperiksa dan diterima?')" class="flex-shrink-0">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg shadow-sm shadow-emerald-900/30 hover:bg-emerald-500 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Konfirmasi
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="flex flex-col items-center gap-2 text-slate-600 py-10">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-medium text-slate-500">Tidak ada tugas.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Barang Keluar --}}
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="h-1 bg-gradient-to-r from-red-500 to-orange-400"></div>
            <div class="px-5 py-4 flex items-center gap-3 border-b border-white/5">
                <div class="w-9 h-9 rounded-lg bg-red-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m0 0l6-6m-6 6l-6-6"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Barang Keluar Perlu Disiapkan</h2>
                    <p class="text-xs text-slate-500">{{ $pendingOut->count() }} tugas menunggu</p>
                </div>
            </div>
            <div class="p-3">
                @forelse($pendingOut as $trx)
                    @php
                        $isLate = $trx->date->isPast() && !$trx->date->isToday();
                        $isToday = $trx->date->isToday();
                    @endphp
                    <div class="row-fade-in flex items-center justify-between gap-3 p-3 rounded-xl hover:bg-red-500/[0.06] transition-colors" style="animation-delay: {{ $loop->index * 40 }}ms">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($trx->product && $trx->product->image)
                                <img src="{{ asset('storage/'.$trx->product->image) }}" class="w-11 h-11 rounded-lg object-cover flex-shrink-0 border border-white/10">
                            @else
                                <div class="w-11 h-11 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-semibold text-white truncate">{{ $trx->product->name ?? '-' }}</p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <p class="text-xs text-slate-500">{{ $trx->quantity }} unit &middot; {{ $trx->date->format('d M Y') }}</p>
                                    @if($isLate)
                                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-red-500/10 text-red-400">Terlambat</span>
                                    @elseif($isToday)
                                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-400">Hari ini</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('stock.out.confirm', $trx->id) }}" method="POST" onsubmit="return confirm('Konfirmasi barang keluar ini sudah disiapkan dan dikirim?')" class="flex-shrink-0">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg shadow-sm shadow-red-900/30 hover:bg-red-500 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Konfirmasi
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="flex flex-col items-center gap-2 text-slate-600 py-10">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-medium text-slate-500">Tidak ada tugas.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
    @endif
</div>
@endsection
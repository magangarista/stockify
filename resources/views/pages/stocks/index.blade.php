@extends('layouts.dashboard')
@section('content')
<div class="p-4 sm:p-6">

    {{-- Header --}}
    <div class="mb-6 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <p class="text-[11px] font-semibold text-blue-400 tracking-widest uppercase mb-1.5">Pergerakan Barang</p>
            <h1 class="text-2xl font-bold text-white tracking-tight">Riwayat Transaksi Stok</h1>
            <p class="text-sm text-slate-400 mt-1">Catatan lengkap barang masuk, keluar, dan penyesuaian stok gudang.</p>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isManajerGudang())
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('stock.in.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 shadow-sm shadow-emerald-900/30 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Barang Masuk
            </a>
            <a href="{{ route('stock.out.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-500 shadow-sm shadow-red-900/30 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Barang Keluar
            </a>
            <a href="{{ route('stock.opname.form') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 hover:border-white/20 transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                Stock Opname
            </a>
        </div>
        @endif
    </div>

    {{-- Notifikasi --}}
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

    {{-- Ringkasan --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-6 h-6 rounded-md bg-white/5 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                </div>
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Total Transaksi</p>
            </div>
            <p class="text-xl font-bold text-white">{{ $transactions->total() }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-6 h-6 rounded-md bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75"/></svg>
                </div>
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Masuk (Halaman Ini)</p>
            </div>
            <p class="text-xl font-bold text-emerald-400">{{ $transactions->where('type', 'in')->count() }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-6 h-6 rounded-md bg-red-500/10 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 19.5v-15m0 0L12.75 11.25M19.5 4.5l-6.75 6.75"/></svg>
                </div>
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Keluar (Halaman Ini)</p>
            </div>
            <p class="text-xl font-bold text-red-400">{{ $transactions->where('type', 'out')->count() }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-6 h-6 rounded-md bg-amber-500/10 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                </div>
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Menunggu Konfirmasi</p>
            </div>
            <p class="text-xl font-bold text-amber-400">{{ $transactions->where('status', '!=', 'confirmed')->count() }}</p>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider text-center">Jumlah</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Dicatat Oleh</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($transactions as $trx)
                    @php
                        $isIn = $trx->type === 'in';
                        $isConfirmed = $trx->status === 'confirmed';
                        $userName = $trx->user->name ?? '-';
                        $initials = collect(explode(' ', $userName))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                    @endphp
                    <tr class="hover:bg-white/[0.04] transition-colors">
                        <td class="px-6 py-4 text-slate-400 whitespace-nowrap">{{ $trx->date->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-semibold text-white whitespace-nowrap">{{ $trx->product->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($isIn)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75"/></svg>
                                    Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-500/10 text-red-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 19.5v-15m0 0L12.75 11.25M19.5 4.5l-6.75 6.75"/></svg>
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-semibold text-white">{{ $trx->quantity }}</td>
                        <td class="px-6 py-4">
                            @if($isConfirmed)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Terkonfirmasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                                    Menunggu
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-slate-700 flex items-center justify-center text-white text-[10px] font-semibold flex-shrink-0">
                                    {{ $initials ?: '-' }}
                                </div>
                                <span class="text-slate-300 whitespace-nowrap">{{ $userName }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400 max-w-xs">
                            @if($trx->notes)
                                <span class="line-clamp-2" title="{{ $trx->notes }}">{{ $trx->notes }}</span>
                            @else
                                <span class="text-slate-600">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25-2.25M12 13.875V8.25m-8.25 0h16.5M6 5.25h12a1.5 1.5 0 011.5 1.5v.75h-15v-.75a1.5 1.5 0 011.5-1.5z"/></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-400">Belum ada transaksi stok</p>
                                <p class="text-xs text-slate-500 mt-1">Riwayat barang masuk dan keluar akan tercatat di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($transactions->hasPages())
    <div class="mt-5">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
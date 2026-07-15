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

    {{-- Header banner --}}
    <div class="mb-6 rounded-xl bg-white/[0.03] border border-white/10 px-6 py-6 sm:px-8 shadow-lg relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl"></div>
        <div class="absolute -right-2 bottom-0 w-24 h-24 bg-blue-400/10 rounded-full blur-xl"></div>
        <div class="relative">
            <h1 class="text-2xl font-bold text-white">Laporan Transaksi Barang Masuk & Keluar</h1>
            <p class="text-sm text-slate-400 mt-1">Pantau riwayat keluar-masuk stok barang berdasarkan periode</p>
        </div>
    </div>

    {{-- Form filter --}}
    <form method="GET" class="mb-6 bg-white/[0.03] border border-white/10 shadow-md rounded-xl p-5 sm:p-6">
        <div class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="flex items-center gap-1.5 mb-1.5 text-xs font-semibold text-slate-500 uppercase tracking-wide">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Dari Tanggal
                </label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="bg-white/5 border border-white/10 text-sm text-slate-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors [color-scheme:dark]">
            </div>
            <div>
                <label class="flex items-center gap-1.5 mb-1.5 text-xs font-semibold text-slate-500 uppercase tracking-wide">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Sampai Tanggal
                </label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       class="bg-white/5 border border-white/10 text-sm text-slate-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors [color-scheme:dark]">
            </div>
            <div>
                <label class="flex items-center gap-1.5 mb-1.5 text-xs font-semibold text-slate-500 uppercase tracking-wide">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Tipe
                </label>
                <select name="type"
                        class="bg-white/5 border border-white/10 text-sm text-slate-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="" class="bg-[#0B1220]">Semua</option>
                    <option value="in" class="bg-[#0B1220]" {{ request('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                    <option value="out" class="bg-[#0B1220]" {{ request('type') == 'out' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-500 hover:shadow-md hover:-translate-y-0.5 focus:ring-4 focus:ring-indigo-500/30 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-white/[0.03] border border-white/10 shadow-md rounded-xl overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-indigo-500 via-blue-500 to-purple-500"></div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-300">
                <thead class="text-xs text-slate-500 uppercase tracking-wide bg-white/[0.02] border-b border-white/10">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($transactions as $trx)
                    <tr class="row-fade-in hover:bg-white/[0.04] transition-colors duration-150" style="animation-delay: {{ $loop->index * 40 }}ms">
                        <td class="px-6 py-4 text-slate-400">{{ $trx->date->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-semibold text-white">{{ $trx->product->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($trx->type === 'in')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 ring-1 ring-emerald-500/20">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19V5m0 0l-6 6m6-6l6 6"/></svg>
                                    Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 ring-1 ring-red-500/20">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m0 0l6-6m-6 6l-6-6"/></svg>
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-white">{{ $trx->quantity }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $trx->user->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m6 10V7M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <p class="text-sm font-medium">Tidak ada data transaksi.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $transactions->links() }}</div>
</div>
@endsection
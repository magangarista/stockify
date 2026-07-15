@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6 max-w-6xl mx-auto">

    @php
        $hour = (int) date('H');
        $greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
        $lowStockCount = $lowStockProducts->count();
    @endphp

    {{-- Header banner --}}
    <div class="mb-6 rounded-2xl bg-[#0B1220] px-6 py-7 sm:px-8 shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute left-1/3 -bottom-10 w-32 h-32 bg-amber-400/10 rounded-full blur-2xl"></div>

        <div class="relative">
            <p class="text-[11px] font-semibold text-blue-400 tracking-widest uppercase mb-1.5">{{ $greeting }}</p>
            <h1 class="text-2xl font-bold text-white">{{ auth()->user()->name }}</h1>
            <p class="text-sm text-slate-400 mt-1">
                @if($lowStockCount > 0)
                    Ada <span class="font-semibold text-amber-400">{{ $lowStockCount }} produk</span> yang stoknya perlu segera dipesan ulang.
                @else
                    Semua stok dalam kondisi aman hari ini.
                @endif
            </p>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"/></svg>
            </div>
            <div>
                <p class="text-sm text-slate-400">Barang Masuk Hari Ini</p>
                <p class="text-2xl font-bold text-white tabular-nums">{{ $stockInToday }}</p>
            </div>
        </div>

        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20V8m0 0l-4 4m4-4l4 4M4 4h16"/></svg>
            </div>
            <div>
                <p class="text-sm text-slate-400">Barang Keluar Hari Ini</p>
                <p class="text-2xl font-bold text-white tabular-nums">{{ $stockOutToday }}</p>
            </div>
        </div>
    </div>

    {{-- Produk Stok Menipis --}}
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/5">
            <div class="w-9 h-9 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-4.5 h-4.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            </div>
            <div>
                <h2 class="font-semibold text-white">Produk dengan Stok Menipis</h2>
                <p class="text-xs text-slate-500">Perlu segera dipesan ulang ke supplier</p>
            </div>
            @if($lowStockCount > 0)
            <span class="ml-auto px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">{{ $lowStockCount }} produk</span>
            @endif
        </div>

        @if($lowStockCount > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Level Stok</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider text-right">Stok Saat Ini</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider text-right">Stok Minimum</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($lowStockProducts as $product)
                    @php
                        $ratio = $product->minimum_stock > 0 ? min(100, ($product->stock / $product->minimum_stock) * 100) : 0;
                        $critical = $product->stock == 0;
                    @endphp
                    <tr class="hover:bg-white/[0.03] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" class="w-9 h-9 rounded-lg object-cover flex-shrink-0 border border-white/10">
                                @else
                                    <div class="w-9 h-9 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-medium text-white truncate">{{ $product->name }}</p>
                                    @if($critical)
                                        <span class="text-[10px] font-semibold text-red-400">Stok habis</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-32 h-1.5 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $critical ? 'bg-red-500' : 'bg-amber-500' }}" style="width: {{ max($ratio, 4) }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold tabular-nums {{ $critical ? 'text-red-400' : 'text-amber-400' }}">{{ $product->stock }}</td>
                        <td class="px-6 py-4 text-right text-slate-500 tabular-nums">{{ $product->minimum_stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-14 text-center">
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-sm font-medium text-white">Semua stok dalam kondisi aman.</p>
            <p class="text-xs text-slate-500 mt-1">Tidak ada produk yang perlu dipesan ulang saat ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
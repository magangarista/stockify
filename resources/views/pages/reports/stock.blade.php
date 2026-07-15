@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6">

    {{-- Header --}}
    <div class="mb-6">
        <p class="text-[11px] font-semibold text-blue-400 tracking-widest uppercase mb-1.5">Laporan</p>
        <h1 class="text-2xl font-bold text-white tracking-tight">Laporan Stok Barang</h1>
        <p class="text-sm text-slate-400 mt-1">Ringkasan kondisi stok seluruh produk dibandingkan batas minimum.</p>
    </div>

    {{-- Ringkasan --}}
    @php
        $totalProducts = $products->count();
        $lowStockCount = $products->filter(fn($p) => $p->isLowStock())->count();
        $safeCount = $totalProducts - $lowStockCount;
        $totalStockValue = $products->sum(fn($p) => $p->selling_price * $p->stock);
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Total Produk</p>
            <p class="text-xl font-bold text-white">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <div class="flex items-center gap-1.5 mb-1">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Stok Aman</p>
            </div>
            <p class="text-xl font-bold text-emerald-400">{{ $safeCount }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <div class="flex items-center gap-1.5 mb-1">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Stok Menipis</p>
            </div>
            <p class="text-xl font-bold text-red-400">{{ $lowStockCount }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Total Nilai Stok</p>
            <p class="text-xl font-bold text-blue-400">Rp{{ number_format($totalStockValue, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Peringatan stok menipis --}}
    @if($lowStockCount > 0)
    <div class="mb-5 flex items-center gap-2.5 px-4 py-3 text-sm text-red-400 rounded-xl bg-red-500/10 border border-red-500/20">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12V16.5zm9-4.5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span><strong class="text-red-300">{{ $lowStockCount }} produk</strong> memiliki stok di bawah batas minimum dan perlu segera diisi ulang.</span>
    </div>
    @endif

    {{-- Tabel --}}
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tingkat Stok</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider text-center">Saat Ini</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider text-center">Minimum</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($products as $product)
                    @php
                        $isLow = $product->isLowStock();
                        $ratioBase = $product->minimum_stock > 0 ? $product->minimum_stock * 2 : max($product->stock, 1);
                        $ratio = $ratioBase > 0 ? min(100, round(($product->stock / $ratioBase) * 100)) : 100;
                    @endphp
                    <tr class="hover:bg-white/[0.04] transition-colors">
                        <td class="px-6 py-4 font-semibold text-white whitespace-nowrap">{{ $product->name }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-white/5 text-slate-300">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 min-w-[140px]">
                            <div class="w-full h-1.5 rounded-full bg-white/10 overflow-hidden">
                                <div class="h-full rounded-full {{ $isLow ? 'bg-red-500' : 'bg-emerald-500' }}" style="width: {{ $ratio }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center font-bold {{ $isLow ? 'text-red-400' : 'text-white' }}">{{ $product->stock }}</td>
                        <td class="px-6 py-4 text-center text-slate-400">{{ $product->minimum_stock }}</td>
                        <td class="px-6 py-4">
                            @if($isLow)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-500/10 text-red-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12V16.5zm9-4.5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Menipis
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Aman
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-400">Belum ada data produk</p>
                                <p class="text-xs text-slate-500 mt-1">Laporan akan muncul setelah ada produk terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
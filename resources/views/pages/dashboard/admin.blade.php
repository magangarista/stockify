@extends('layouts.dashboard')
@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeInUp 0.4s ease-out both; }
</style>

<div class="min-h-full bg-gray-950 p-4 sm:p-6">

    <h1 class="text-xl font-semibold text-white mb-5">Dashboard Admin</h1>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">

        <div class="fade-in bg-gray-900 border border-gray-800 rounded-xl p-5 flex items-center justify-between hover:border-gray-700 transition-colors" style="animation-delay: 0ms">
            <div>
                <p class="text-2xl font-bold text-white">{{ $totalProducts }}</p>
                <p class="text-sm text-gray-400 mt-1">Total Produk</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-sky-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>

        <div class="fade-in bg-gray-900 border border-gray-800 rounded-xl p-5 flex items-center justify-between hover:border-gray-700 transition-colors" style="animation-delay: 60ms">
            <div>
                <p class="text-2xl font-bold text-white">{{ $totalStockIn }}</p>
                <p class="text-sm text-gray-400 mt-1">Barang Masuk Hari Ini</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-6 6m6-6l6 6"/></svg>
            </div>
        </div>

        <div class="fade-in bg-gray-900 border border-gray-800 rounded-xl p-5 flex items-center justify-between hover:border-gray-700 transition-colors" style="animation-delay: 120ms">
            <div>
                <p class="text-2xl font-bold text-white">{{ $totalStockOut }}</p>
                <p class="text-sm text-gray-400 mt-1">Barang Keluar Hari Ini</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-violet-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m0 0l6-6m-6 6l-6-6"/></svg>
            </div>
        </div>

        <div class="fade-in bg-gray-900 border border-gray-800 rounded-xl p-5 flex items-center justify-between hover:border-gray-700 transition-colors" style="animation-delay: 180ms">
            <div>
                <p class="text-2xl font-bold text-white">{{ $totalUsers }}</p>
                <p class="text-sm text-gray-400 mt-1">Total Pengguna</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-pink-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 2c1.657 0 3-1.567 3-3.5S19.657 8 18 8m-12 5c-1.657 0-3-1.567-3-3.5S4.343 8 6 8"/></svg>
            </div>
        </div>
    </div>

    {{-- Dua grafik sejajar --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

        {{-- Grafik garis: tren 7 hari --}}
        <div class="fade-in bg-gray-900 border border-gray-800 rounded-xl p-5" style="animation-delay: 240ms">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-white">Tren Barang Masuk & Keluar (7 Hari)</h2>
                <div class="flex items-center gap-3 text-xs text-gray-400">
                    <span class="inline-flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400"></span>Masuk</span>
                    <span class="inline-flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-400"></span>Keluar</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- Grafik bar: stok per kategori --}}
        <div class="fade-in bg-gray-900 border border-gray-800 rounded-xl p-5" style="animation-delay: 280ms">
            <h2 class="text-base font-semibold text-white mb-4">Stok Barang per Kategori</h2>
            <div class="h-64">
                <canvas id="stockChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Aktivitas Transaksi Terbaru --}}
    <div class="fade-in bg-gray-900 border border-gray-800 rounded-xl overflow-hidden" style="animation-delay: 320ms">
        <div class="px-5 py-4 border-b border-gray-800">
            <h2 class="text-base font-semibold text-white">Aktivitas Transaksi Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase tracking-wide bg-black/20 border-b border-gray-800">
                    <tr>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Produk</th>
                        <th class="px-5 py-3">Tipe</th>
                        <th class="px-5 py-3">Jumlah</th>
                        <th class="px-5 py-3">Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($recentTransactions as $trx)
                    <tr class="fade-in hover:bg-white/5 transition-colors" style="animation-delay: {{ 360 + $loop->index * 40 }}ms">
                        <td class="px-5 py-3 text-gray-400">{{ $trx->date->format('d M Y') }}</td>
                        <td class="px-5 py-3 font-medium text-white">{{ $trx->product->name ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if($trx->type === 'in')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 ring-1 ring-emerald-500/30">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19V5m0 0l-6 6m6-6l6 6"/></svg>
                                    Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 ring-1 ring-red-500/30">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m0 0l6-6m-6 6l-6-6"/></svg>
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-semibold text-white">{{ $trx->quantity }}</td>
                        <td class="px-5 py-3 text-gray-400">{{ $trx->user->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-medium">Belum ada aktivitas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // ===== Grafik garis: tren 7 hari (wavy/smooth) =====
    const trendLabels = {!! json_encode($trendLabels) !!};
    const trendIn = {!! json_encode($trendIn) !!};
    const trendOut = {!! json_encode($trendOut) !!};

    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [
                {
                    label: 'Masuk',
                    data: trendIn,
                    borderColor: '#34d399',
                    backgroundColor: 'rgba(52, 211, 153, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#34d399',
                    borderWidth: 2,
                },
                {
                    label: 'Keluar',
                    data: trendOut,
                    borderColor: '#f87171',
                    backgroundColor: 'rgba(248, 113, 113, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#f87171',
                    borderWidth: 2,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#f9fafb',
                    bodyColor: '#d1d5db',
                    padding: 12,
                    cornerRadius: 8,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, color: '#9ca3af' },
                    grid: { color: 'rgba(255,255,255,0.06)' }
                },
                x: {
                    ticks: { color: '#9ca3af' },
                    grid: { display: false }
                }
            },
            animation: { duration: 800, easing: 'easeOutQuart' }
        }
    });

    // ===== Grafik bar: stok per kategori =====
    const palette = ['#6366f1', '#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#ec4899', '#14b8a6', '#ef4444'];
    const chartLabels = {!! json_encode($chartLabels) !!};
    const chartData = {!! json_encode($chartData) !!};
    const barColors = chartLabels.map((_, i) => palette[i % palette.length]);

    new Chart(document.getElementById('stockChart'), {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Total Stok',
                data: chartData,
                backgroundColor: barColors,
                borderRadius: 8,
                maxBarThickness: 36,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#f9fafb',
                    bodyColor: '#d1d5db',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, color: '#9ca3af' },
                    grid: { color: 'rgba(255,255,255,0.06)' }
                },
                x: {
                    ticks: { color: '#9ca3af' },
                    grid: { display: false }
                }
            },
            animation: { duration: 800, easing: 'easeOutQuart' }
        }
    });
</script>
@endpush
@endsection
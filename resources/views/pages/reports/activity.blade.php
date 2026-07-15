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
            <h1 class="text-2xl font-bold text-white">Laporan Aktivitas Pengguna</h1>
            <p class="text-sm text-slate-400 mt-1">Riwayat aktivitas seluruh pengguna di sistem</p>
        </div>
    </div>

    {{-- Form filter --}}
    <form method="GET" class="mb-6 bg-white/[0.03] border border-white/10 shadow-md rounded-xl p-5 sm:p-6">
        <div class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="flex items-center gap-1.5 mb-1.5 text-xs font-semibold text-slate-500 uppercase tracking-wide">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Pengguna
                </label>
                <select name="user_id"
                        class="bg-white/5 border border-white/10 text-sm text-slate-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="" class="bg-[#0B1220]">Semua Pengguna</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" class="bg-[#0B1220]" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
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
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Aksi</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($logs as $log)
                    @php
                        $action = strtolower($log->action);
                        $badgeClass = 'bg-white/5 text-slate-400 ring-white/10';
                        if (str_contains($action, 'login')) {
                            $badgeClass = 'bg-emerald-500/10 text-emerald-400 ring-emerald-500/20';
                        } elseif (str_contains($action, 'logout')) {
                            $badgeClass = 'bg-white/5 text-slate-400 ring-white/10';
                        } elseif (str_contains($action, 'in')) {
                            $badgeClass = 'bg-blue-500/10 text-blue-400 ring-blue-500/20';
                        } elseif (str_contains($action, 'out')) {
                            $badgeClass = 'bg-orange-500/10 text-orange-400 ring-orange-500/20';
                        } elseif (str_contains($action, 'delete') || str_contains($action, 'hapus')) {
                            $badgeClass = 'bg-red-500/10 text-red-400 ring-red-500/20';
                        } elseif (str_contains($action, 'update') || str_contains($action, 'edit')) {
                            $badgeClass = 'bg-amber-500/10 text-amber-400 ring-amber-500/20';
                        } elseif (str_contains($action, 'create') || str_contains($action, 'tambah')) {
                            $badgeClass = 'bg-indigo-500/10 text-indigo-400 ring-indigo-500/20';
                        }
                    @endphp
                    <tr class="row-fade-in hover:bg-white/[0.04] transition-colors duration-150" style="animation-delay: {{ $loop->index * 30 }}ms">
                        <td class="px-6 py-4 text-slate-400 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xs font-semibold">
                                        {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                    </span>
                                </div>
                                <span class="font-semibold text-white">{{ $log->user->name ?? 'Sistem' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ring-1 {{ $badgeClass }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 max-w-md">{{ $log->description }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-medium">Belum ada aktivitas tercatat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $logs->links() }}</div>
</div>
@endsection
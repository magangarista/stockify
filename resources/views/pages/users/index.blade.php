@extends('layouts.dashboard')
@section('content')
<div class="p-4 sm:p-6">

    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <p class="text-[11px] font-semibold text-blue-400 tracking-widest uppercase mb-1.5">Akses & Peran</p>
            <h1 class="text-2xl font-bold text-white tracking-tight">Manajemen Pengguna</h1>
            <p class="text-sm text-slate-400 mt-1">Kelola akun tim dan tentukan peran akses masing-masing pengguna.</p>
        </div>
        <a href="{{ route('users.create') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-500 shadow-sm shadow-blue-900/30 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Pengguna
        </a>
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
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Total Pengguna</p>
            <p class="text-xl font-bold text-white">{{ $users->total() }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Admin</p>
            <p class="text-xl font-bold text-indigo-400">{{ $users->where('role', 'Admin')->count() }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Manajer Gudang</p>
            <p class="text-xl font-bold text-blue-400">{{ $users->where('role', 'Manajer Gudang')->count() }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Staff Gudang</p>
            <p class="text-xl font-bold text-teal-400">{{ $users->where('role', 'Staff Gudang')->count() }}</p>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                    @php
                        $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');

                        $roleStyles = [
                            'Admin' => ['avatar' => 'bg-indigo-600', 'badge' => 'bg-indigo-500/10 text-indigo-400'],
                            'Manajer Gudang' => ['avatar' => 'bg-blue-600', 'badge' => 'bg-blue-500/10 text-blue-400'],
                            'Staff Gudang' => ['avatar' => 'bg-teal-600', 'badge' => 'bg-teal-500/10 text-teal-400'],
                        ];
                        $style = $roleStyles[$user->role] ?? ['avatar' => 'bg-slate-600', 'badge' => 'bg-white/5 text-slate-400'];
                        $isSelf = $user->id === auth()->id();
                    @endphp
                    <tr class="hover:bg-white/[0.04] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full {{ $style['avatar'] }} flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                    {{ $initials ?: '-' }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-white">{{ $user->name }}</span>
                                    @if($isSelf)
                                        <span class="text-[10px] font-medium px-1.5 py-0.5 rounded bg-white/5 text-slate-400">Anda</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $style['badge'] }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('users.edit', $user->id) }}" title="Edit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:text-blue-400 hover:bg-blue-500/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                </a>
                                @if(!$isSelf)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-500/10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                                @else
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-700" title="Tidak bisa menghapus akun sendiri">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-400">Belum ada data pengguna</p>
                                <p class="text-xs text-slate-500 mt-1">Tambahkan anggota tim pertama Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="mt-5">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
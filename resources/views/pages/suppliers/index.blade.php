@extends('layouts.dashboard')
@section('content')
<div class="p-4 sm:p-6">

    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <p class="text-[11px] font-semibold text-blue-400 tracking-widest uppercase mb-1.5">Manajemen Relasi</p>
            <h1 class="text-2xl font-bold text-white tracking-tight">Supplier</h1>
            <p class="text-sm text-slate-400 mt-1">Kelola mitra pemasok dan pantau kontribusi produk mereka ke gudang Anda.</p>
        </div>
        <a href="{{ route('suppliers.create') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-500 shadow-sm shadow-blue-900/30 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Supplier
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
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Total Supplier</p>
            <p class="text-xl font-bold text-white">{{ $suppliers->total() }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5">
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Halaman Ini</p>
            <p class="text-xl font-bold text-white">{{ $suppliers->count() }} <span class="text-sm font-normal text-slate-500">supplier</span></p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5 col-span-2 sm:col-span-1">
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Produk Terhubung</p>
            <p class="text-xl font-bold text-blue-400">{{ $suppliers->sum('products_count') }}</p>
        </div>
        <div class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3.5 col-span-2 sm:col-span-1">
            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide mb-1">Belum Punya Produk</p>
            <p class="text-xl font-bold text-amber-400">{{ $suppliers->where('products_count', 0)->count() }}</p>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white/[0.03] border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider text-center">Produk</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($suppliers as $index => $supplier)
                    @php
                        $palette = ['bg-blue-600', 'bg-indigo-600', 'bg-slate-600', 'bg-sky-600'];
                        $accent = $palette[$index % count($palette)];
                        $initials = collect(explode(' ', $supplier->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                    @endphp
                    <tr class="hover:bg-white/[0.04] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full {{ $accent }} flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                    {{ $initials ?: '-' }}
                                </div>
                                <span class="font-semibold text-white">{{ $supplier->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400 max-w-xs">
                            <div class="flex items-start gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                <span class="line-clamp-2">{{ $supplier->address ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-3.5 h-3.5 text-slate-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                    {{ $supplier->phone ?? '-' }}
                                </div>
                                @if($supplier->email)
                                <a href="mailto:{{ $supplier->email }}" class="flex items-center gap-1.5 text-blue-400 hover:text-blue-300 hover:underline w-fit">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    {{ $supplier->email }}
                                </a>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center min-w-[2rem] px-2.5 py-1 rounded-full text-xs font-semibold {{ $supplier->products_count > 0 ? 'bg-blue-500/10 text-blue-400' : 'bg-white/5 text-slate-500' }}">
                                {{ $supplier->products_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" title="Edit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:text-blue-400 hover:bg-blue-500/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-500/10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-400">Belum ada data supplier</p>
                                <p class="text-xs text-slate-500 mt-1">Mulai tambahkan mitra pemasok pertama Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($suppliers->hasPages())
    <div class="mt-5">
        {{ $suppliers->links() }}
    </div>
    @endif
</div>
@endsection
@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6 max-w-5xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-white mb-3 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Manajemen Pengguna
        </a>
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">Tambah Pengguna</h1>
                <p class="text-sm text-slate-400">Buat akun baru dan tentukan peran yang menentukan hak aksesnya.</p>
            </div>
        </div>
    </div>

    <div
        x-data="{
            role: '{{ old('role') }}',
            showPassword: false,
            roles: [
                {
                    value: 'Admin',
                    title: 'Admin',
                    desc: 'Akses penuh ke semua modul.',
                    perks: ['Kelola produk, kategori & supplier', 'Kelola pengguna & pengaturan', 'Lihat semua laporan'],
                    color: 'indigo'
                },
                {
                    value: 'Manajer Gudang',
                    title: 'Manajer Gudang',
                    desc: 'Mengelola operasional stok harian.',
                    perks: ['Tambah & edit produk', 'Catat barang masuk / keluar', 'Lihat laporan stok & transaksi'],
                    color: 'blue'
                },
                {
                    value: 'Staff Gudang',
                    title: 'Staff Gudang',
                    desc: 'Menjalankan tugas lapangan gudang.',
                    perks: ['Lihat produk & supplier', 'Konfirmasi barang masuk / keluar', 'Tidak bisa ubah data master'],
                    color: 'amber'
                }
            ]
        }"
        class="grid grid-cols-1 lg:grid-cols-3 gap-6"
    >
        <!-- Form -->
        <div class="lg:col-span-2 bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="h-1 bg-indigo-500"></div>
            <form action="{{ route('users.store') }}" method="POST" class="p-6 sm:p-8 space-y-5">
                @csrf
                <input type="hidden" name="role" x-model="role">

                <div>
                    <label for="name" class="block mb-1.5 text-sm font-medium text-slate-300">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" class="bg-white/5 border border-white/10 text-slate-100 placeholder-slate-500 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 block w-full p-2.5" required>
                    @error('name') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block mb-1.5 text-sm font-medium text-slate-300">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="nama@stockify.test" class="bg-white/5 border border-white/10 text-slate-100 placeholder-slate-500 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 block w-full p-2.5" required>
                    @error('email') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block mb-1.5 text-sm font-medium text-slate-300">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" id="password" placeholder="Minimal 8 karakter" class="bg-white/5 border border-white/10 text-slate-100 placeholder-slate-500 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 block w-full p-2.5 pr-10" required>
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/></svg>
                        </button>
                    </div>
                    @error('password') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Peran (Role)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <template x-for="r in roles" :key="r.value">
                            <button
                                type="button"
                                @click="role = r.value"
                                class="text-left p-3.5 rounded-xl border-2 transition-all"
                                :class="role === r.value
                                    ? (r.color === 'indigo' ? 'border-indigo-500 bg-indigo-500/10' : r.color === 'blue' ? 'border-blue-500 bg-blue-500/10' : 'border-amber-500 bg-amber-500/10')
                                    : 'border-white/10 hover:border-white/20 bg-white/[0.02]'"
                            >
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-semibold text-white" x-text="r.title"></span>
                                    <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0"
                                        :class="role === r.value
                                            ? (r.color === 'indigo' ? 'border-indigo-500' : r.color === 'blue' ? 'border-blue-500' : 'border-amber-500')
                                            : 'border-white/20'">
                                        <span x-show="role === r.value" class="w-2 h-2 rounded-full"
                                            :class="r.color === 'indigo' ? 'bg-indigo-500' : r.color === 'blue' ? 'bg-blue-500' : 'bg-amber-500'"></span>
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500" x-text="r.desc"></p>
                            </button>
                        </template>
                    </div>
                    @error('role') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500 shadow-sm shadow-indigo-900/30 transition-colors">Simpan Pengguna</button>
                    <a href="{{ route('users.index') }}" class="px-6 py-2.5 text-sm font-medium text-slate-300 bg-white/5 border border-white/10 rounded-lg hover:bg-white/10 transition-colors">Batal</a>
                </div>
            </form>
        </div>

        <!-- Preview hak akses -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm p-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-4">Hak Akses Peran</p>

                <template x-if="!role">
                    <div class="py-10 text-center">
                        <svg class="w-10 h-10 mx-auto text-slate-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-slate-500">Pilih peran untuk melihat rincian hak aksesnya</p>
                    </div>
                </template>

                <template x-for="r in roles" :key="r.value">
                    <div x-show="role === r.value" x-cloak>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2.5 h-2.5 rounded-full"
                                :class="r.color === 'indigo' ? 'bg-indigo-500' : r.color === 'blue' ? 'bg-blue-500' : 'bg-amber-500'"></span>
                            <span class="font-semibold text-white" x-text="r.title"></span>
                        </div>
                        <ul class="space-y-2.5">
                            <template x-for="perk in r.perks" :key="perk">
                                <li class="flex items-start gap-2 text-sm text-slate-400">
                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" :class="r.color === 'indigo' ? 'text-indigo-400' : r.color === 'blue' ? 'text-blue-400' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span x-text="perk"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection
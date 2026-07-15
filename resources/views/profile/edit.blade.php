@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <p class="text-[11px] font-semibold text-blue-400 tracking-widest uppercase mb-1.5">Akun Saya</p>
        <h1 class="text-2xl font-bold text-white tracking-tight">Profil Saya</h1>
        <p class="text-sm text-slate-400 mt-1">Kelola informasi akun dan keamanan login kamu.</p>
    </div>

    @if(session('status') === 'avatar-updated')
        <div class="mb-5 flex items-center gap-2.5 px-4 py-3 text-sm text-emerald-400 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Foto profil berhasil diperbarui.
        </div>
    @endif

    <div class="space-y-5">

        {{-- Header profil dengan avatar --}}
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm p-6 sm:p-8 flex items-center gap-5 flex-wrap">
            <div class="relative flex-shrink-0">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="Foto profil" class="w-16 h-16 rounded-full object-cover ring-2 ring-white/10">
                @else
                    <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center">
                        <span class="text-white text-2xl font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="flex-1 min-w-[200px]">
                <h3 class="text-lg font-semibold text-white">{{ auth()->user()->name }}</h3>
                <p class="text-sm text-slate-400">{{ auth()->user()->email }}</p>
                <span class="inline-flex items-center mt-2 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                    {{ auth()->user()->role }}
                </span>
            </div>

            <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                    Pilih Foto
                    <input type="file" name="avatar" accept="image/*" class="hidden" onchange="this.form.submit()">
                </label>
            </form>
        </div>

        @error('avatar')
            <div class="flex items-center gap-2.5 px-4 py-3 text-sm text-red-400 rounded-xl bg-red-500/10 border border-red-500/20">{{ $message }}</div>
        @enderror

        {{-- Informasi Profil --}}
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 sm:px-8 py-5 border-b border-white/5 flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-white">Informasi Profil</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui nama dan alamat email akun kamu.</p>
                </div>
            </div>
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Ubah Kata Sandi --}}
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 sm:px-8 py-5 border-b border-white/5 flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-white">Ubah Kata Sandi</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Gunakan kata sandi yang panjang dan acak agar akun tetap aman.</p>
                </div>
            </div>
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Zona Berbahaya --}}
        <div class="bg-red-500/[0.04] border border-red-500/20 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 sm:px-8 py-5 border-b border-red-500/10 flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-red-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-white">Hapus Akun</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Tindakan ini permanen dan tidak bisa dibatalkan.</p>
                </div>
            </div>
            <div class="p-6 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>
@endsection
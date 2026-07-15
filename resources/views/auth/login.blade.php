<x-guest-layout>
    <div class="min-h-screen flex">

        {{-- Panel Kiri: Brand + Ilustrasi Rak Gudang --}}
        <div class="hidden lg:flex lg:w-[45%] bg-[#0B1220] relative overflow-hidden flex-col justify-between p-12">
            <div class="relative z-10">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded bg-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="font-display text-white text-lg font-semibold">Stockify</span>
                </div>
                <p class="font-mono-tag text-[11px] text-blue-400 mt-1 tracking-wide">SISTEM MANAJEMEN STOK GUDANG</p>
            </div>

            <div class="relative z-10 flex-1 flex items-center justify-center py-8">
                <div class="relative w-64 h-72">
                    <div class="grid grid-cols-4 gap-3">
                        @php $filled = [1,2,4,6,7,9,10,11,13,15]; @endphp
                        @for($i = 0; $i < 16; $i++)
                            <div class="w-12 h-16 rounded-sm border {{ in_array($i, $filled) ? 'bg-blue-600/20 border-blue-500/40' : 'bg-white/[0.03] border-white/10' }} flex items-end justify-center">
                                @if(in_array($i, $filled))
                                    <div class="w-6 h-1 mb-2 rounded-full bg-amber-400/70"></div>
                                @endif
                            </div>
                        @endfor
                    </div>
                    <div class="scanline absolute left-0 top-0 w-full h-[2px] bg-blue-400 shadow-[0_0_12px_2px_rgba(96,165,250,0.6)]"></div>
                </div>
            </div>

            <div class="relative z-10">
                <p class="font-display text-white text-2xl font-medium leading-snug">
                    Setiap barang<br>tercatat, setiap saat.
                </p>
                <p class="text-slate-400 text-sm mt-3 max-w-xs">
                    Pantau stok masuk, keluar, dan opname gudang secara real-time dalam satu sistem.
                </p>
            </div>
        </div>

        {{-- Panel Kanan: Form Login --}}
        <div class="w-full lg:w-[55%] flex items-center justify-center bg-[#F7F7F5] p-6 sm:p-12">
            <div class="w-full max-w-sm">

                <div class="lg:hidden flex items-center gap-2 mb-10">
                    <div class="w-8 h-8 rounded bg-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="font-display text-lg font-semibold text-slate-900">Stockify</span>
                </div>

                <p class="font-mono-tag text-[11px] text-blue-600 tracking-wide mb-2">SELAMAT DATANG KEMBALI</p>
                <h1 class="font-display text-2xl font-semibold text-slate-900 mb-1">Masuk ke akun Anda</h1>
                <p class="text-sm text-slate-500 mb-8">Kelola stok gudang Anda dengan lebih akurat.</p>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition"
                            placeholder="nama@stockify.test">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-slate-700">{{ __('Password') }}</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition"
                            placeholder="•••••••�?>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <label for="remember_me" class="ml-2 text-sm text-slate-600">{{ __('Remember me') }}</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition focus:ring-4 focus:ring-blue-200">
                        {{ __('Log in') }}
                    </button>
                </form>

                <p class="font-mono-tag text-center text-[11px] text-slate-400 mt-10 tracking-wide">
                    STOCKIFY WMS · v1.0
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>

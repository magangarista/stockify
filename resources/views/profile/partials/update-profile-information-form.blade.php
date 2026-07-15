<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <div>
        <label for="name" class="block mb-1.5 text-sm font-medium text-slate-300">Nama</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
            class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors"
            required autofocus autocomplete="name">
        @error('name') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block mb-1.5 text-sm font-medium text-slate-300">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
            class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors"
            required autocomplete="username">
        @error('email') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-3 p-3 bg-amber-500/10 border border-amber-500/20 rounded-xl">
                <p class="text-sm text-amber-300">
                    Alamat email kamu belum terverifikasi.
                    <button form="send-verification" class="underline font-medium hover:text-amber-200 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#0B1220] focus:ring-amber-500">
                        Klik di sini untuk kirim ulang email verifikasi.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-emerald-400">
                        Link verifikasi baru telah dikirim ke alamat email kamu.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button type="submit"
            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-500 shadow-sm shadow-blue-900/30 transition-colors">
            Simpan Perubahan
        </button>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 2000)"
                x-transition
                class="text-sm text-emerald-400 font-medium"
            >Tersimpan.</p>
        @endif
    </div>
</form>
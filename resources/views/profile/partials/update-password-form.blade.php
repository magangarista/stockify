<form method="post" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('put')

    <div>
        <label for="update_password_current_password" class="block mb-1.5 text-sm font-medium text-slate-300">Kata Sandi Saat Ini</label>
        <input type="password" name="current_password" id="update_password_current_password" autocomplete="current-password"
            class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors">
        @error('current_password', 'updatePassword') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="update_password_password" class="block mb-1.5 text-sm font-medium text-slate-300">Kata Sandi Baru</label>
        <input type="password" name="password" id="update_password_password" autocomplete="new-password"
            class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors">
        @error('password', 'updatePassword') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="update_password_password_confirmation" class="block mb-1.5 text-sm font-medium text-slate-300">Konfirmasi Kata Sandi Baru</label>
        <input type="password" name="password_confirmation" id="update_password_password_confirmation" autocomplete="new-password"
            class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors">
        @error('password_confirmation', 'updatePassword') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button type="submit"
            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-500 shadow-sm shadow-blue-900/30 transition-colors">
            Simpan Kata Sandi
        </button>

        @if (session('status') === 'password-updated')
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
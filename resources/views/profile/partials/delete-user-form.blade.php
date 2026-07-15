<div x-data="{ confirmingDeletion: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }" class="space-y-4">
    <p class="text-sm text-slate-400">
        Setelah akun kamu dihapus, semua data dan sumber daya terkait akan dihapus secara permanen.
        Sebelum menghapus akun, silakan unduh data atau informasi apa pun yang ingin kamu simpan.
    </p>

    <button type="button" @click="confirmingDeletion = true"
        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-500 shadow-sm shadow-red-900/30 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        Hapus Akun
    </button>

    {{-- Modal konfirmasi --}}
    <div x-show="confirmingDeletion" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">

        {{-- Backdrop --}}
        <div x-show="confirmingDeletion" x-transition.opacity @click="confirmingDeletion = false"
            class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        {{-- Konten modal --}}
        <div x-show="confirmingDeletion"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="relative bg-[#0F1729] border border-white/10 rounded-2xl shadow-2xl w-full max-w-md p-6">

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h2 class="text-lg font-semibold text-white">
                    Apakah kamu yakin ingin menghapus akun ini?
                </h2>

                <p class="mt-1.5 text-sm text-slate-400">
                    Setelah akun dihapus, semua data dan sumber daya terkait akan dihapus secara permanen.
                    Masukkan kata sandi untuk konfirmasi penghapusan akun secara permanen.
                </p>

                <div class="mt-5">
                    <label for="password" class="sr-only">Kata Sandi</label>
                    <input type="password" name="password" id="password" placeholder="Kata Sandi"
                        class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-red-500/40 focus:border-red-500 block w-full p-3 transition-colors">
                    @error('password', 'userDeletion') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="confirmingDeletion = false"
                        class="px-5 py-2.5 text-sm font-medium text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-500 transition-colors">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
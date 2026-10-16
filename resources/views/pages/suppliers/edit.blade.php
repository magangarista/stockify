@extends('layouts.dashboard')

@section('content')
<div class="min-h-full bg-gray-950 p-4 sm:p-6">

    <div class="mb-5">
        <h1 class="text-xl font-semibold text-white">Edit Supplier</h1>
        <p class="text-sm text-gray-400 mt-1">Perbarui informasi mitra pemasok</p>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden max-w-lg">
        <div class="p-6 sm:p-8">
            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block mb-1.5 text-sm font-semibold text-gray-300">Nama Supplier</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}"
                           class="bg-gray-950 border border-gray-700 text-white text-sm rounded-lg block w-full p-2.5 placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                    @error('name') <p class="text-sm text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="address" class="block mb-1.5 text-sm font-semibold text-gray-300">Alamat</label>
                    <textarea name="address" id="address" rows="2"
                              class="bg-gray-950 border border-gray-700 text-white text-sm rounded-lg block w-full p-2.5 placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">{{ old('address', $supplier->address) }}</textarea>
                    @error('address') <p class="text-sm text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" class="block mb-1.5 text-sm font-semibold text-gray-300">Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}"
                           inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9-]/g, '')"
                           class="bg-gray-950 border border-gray-700 text-white text-sm rounded-lg block w-full p-2.5 placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    @error('phone') <p class="text-sm text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block mb-1.5 text-sm font-semibold text-gray-300">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}"
                           class="bg-gray-950 border border-gray-700 text-white text-sm rounded-lg block w-full p-2.5 placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    @error('email') <p class="text-sm text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Update
                    </button>
                    <a href="{{ route('suppliers.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-gray-300 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
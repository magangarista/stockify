@extends('layouts.dashboard')

@section('content')
<div class="min-h-full bg-gray-950 p-4 sm:p-6">

    <div class="mb-5">
        <h1 class="text-xl font-semibold text-white">Edit Kategori</h1>
        <p class="text-sm text-gray-400 mt-1">Perbarui informasi kategori produk</p>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden max-w-lg">
        <div class="p-6 sm:p-8">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block mb-1.5 text-sm font-semibold text-gray-300">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                           class="bg-gray-950 border border-gray-700 text-white text-sm rounded-lg block w-full p-2.5 placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                    @error('name') <p class="text-sm text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block mb-1.5 text-sm font-semibold text-gray-300">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              class="bg-gray-950 border border-gray-700 text-white text-sm rounded-lg block w-full p-2.5 placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">{{ old('description', $category->description) }}</textarea>
                    @error('description') <p class="text-sm text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Update
                    </button>
                    <a href="{{ route('categories.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-gray-300 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
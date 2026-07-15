@extends('layouts.dashboard')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .row-fade-in {
        animation: fadeInUp 0.35s ease-out both;
    }
</style>

<div class="min-h-full bg-gray-950 p-4 sm:p-6">

    {{-- Header --}}
    <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-white">Manajemen Produk</h1>
            <p class="text-sm text-gray-400 mt-1">Kelola seluruh data produk yang tersimpan di gudang</p>
        </div>
        @if(auth()->user()->isAdmin() || auth()->user()->isManajerGudang())
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-500 hover:-translate-y-0.5 transition-all duration-200">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            Tambah Produk
        </a>
        @endif
    </div>

    {{-- Filter kategori --}}
    <div class="mb-5 flex flex-wrap gap-2">
        <a href="{{ route('products.index') }}"
           class="px-4 py-2 rounded-full text-sm font-medium transition-colors
           {{ !request('category_id') ? 'bg-blue-600 text-white' : 'bg-gray-900 text-gray-400 border border-gray-800 hover:bg-gray-800' }}">
            Semua
        </a>
        @foreach($categories as $category)
        <a href="{{ route('products.index', ['category_id' => $category->id]) }}"
           class="px-4 py-2 rounded-full text-sm font-medium transition-colors
           {{ request('category_id') == $category->id ? 'bg-blue-600 text-white' : 'bg-gray-900 text-gray-400 border border-gray-800 hover:bg-gray-800' }}">
            {{ $category->name }}
            <span class="ml-1 {{ request('category_id') == $category->id ? 'text-blue-200' : 'text-gray-500' }}">({{ $category->products_count }})</span>
        </a>
        @endforeach
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 p-4 text-sm text-emerald-400 rounded-lg bg-emerald-500/10 border-l-4 border-emerald-500" role="alert">
            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid kartu produk --}}
    @if($products->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($products as $product)
        <div class="row-fade-in bg-gray-900 border border-gray-800 rounded-xl hover:border-gray-700 transition-all duration-200 overflow-hidden flex flex-col"
             style="animation-delay: {{ $loop->index * 40 }}ms">

            {{-- Gambar --}}
            <div class="relative h-28 bg-black/30">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-600 text-xs">No Image</div>
                @endif
                <span class="absolute top-2 right-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold
                    {{ $product->isLowStock() ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-white/80"></span>
                    {{ $product->stock }}
                </span>
            </div>

            {{-- Konten --}}
            <div class="p-3 flex flex-col flex-1">
                <h3 class="text-sm font-semibold text-white truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                <p class="text-[11px] font-mono text-gray-500 mt-0.5">{{ $product->sku }}</p>

                <div class="flex items-center gap-1 mt-2">
                    <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-500/10 text-blue-400 truncate">
                        {{ $product->category->name ?? '-' }}
                    </span>
                </div>

                <p class="text-xs text-gray-500 mt-1.5 truncate">{{ $product->supplier->name ?? '-' }}</p>

                <p class="text-sm font-bold text-white mt-2">Rp{{ number_format($product->selling_price, 0, ',', '.') }}</p>

                {{-- Aksi --}}
                <div class="flex items-center gap-1 mt-3 pt-2 border-t border-gray-800">
                    <a href="{{ route('products.show', $product->id) }}"
                       title="Detail"
                       class="flex-1 flex items-center justify-center p-1.5 rounded-lg text-gray-500 hover:text-indigo-400 hover:bg-indigo-500/10 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->isManajerGudang())
                    <a href="{{ route('products.edit', $product->id) }}"
                       title="Edit"
                       class="flex-1 flex items-center justify-center p-1.5 rounded-lg text-gray-500 hover:text-amber-400 hover:bg-amber-500/10 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                title="Hapus"
                                class="w-full flex items-center justify-center p-1.5 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-500/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-gray-900 border border-gray-800 rounded-xl py-16 text-center">
        <div class="flex flex-col items-center gap-2 text-gray-500">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <p class="text-sm font-medium">Belum ada data produk.</p>
        </div>
    </div>
    @endif

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
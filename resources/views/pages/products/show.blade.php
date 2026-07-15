@extends('layouts.dashboard')

@section('content')
<div class="min-h-full p-4 sm:p-6">

    {{-- Header banner --}}
    <div class="mb-6 rounded-xl bg-white/[0.03] border border-white/10 px-6 py-6 sm:px-8 shadow-lg relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl"></div>
        <div class="absolute -right-2 bottom-0 w-24 h-24 bg-amber-400/10 rounded-full blur-xl"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Detail Produk</h1>
                <p class="text-sm text-slate-400 mt-1">Informasi lengkap produk yang tersimpan di gudang</p>
            </div>
            <div class="flex gap-2">
                @if(auth()->user()->isAdmin() || auth()->user()->isManajerGudang())
                <a href="{{ route('products.edit', $product->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-900 bg-amber-400 rounded-lg shadow-sm hover:bg-amber-300 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                @endif
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-white/10 border border-white/20 rounded-lg hover:bg-white/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 p-4 text-sm text-emerald-400 rounded-lg bg-emerald-500/10 border-l-4 border-emerald-500" role="alert">
            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Konten utama --}}
    <div class="bg-white/[0.03] border border-white/10 shadow-md rounded-xl overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-amber-400"></div>

        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Gambar --}}
                <div>
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-56 rounded-xl object-cover shadow-md ring-1 ring-white/10">
                    @else
                        <div class="w-full h-56 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-500 text-sm">Tidak ada gambar</div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-white mb-1">{{ $product->name }}</h2>
                    <p class="text-sm font-mono text-slate-500 mb-5">SKU: {{ $product->sku }}</p>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-lg bg-blue-500/[0.06] border border-blue-500/20">
                            <p class="text-xs font-medium text-blue-400 uppercase tracking-wide">Kategori</p>
                            <p class="font-semibold text-white mt-0.5">{{ $product->category->name ?? '-' }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-purple-500/[0.06] border border-purple-500/20">
                            <p class="text-xs font-medium text-purple-400 uppercase tracking-wide">Supplier</p>
                            <p class="font-semibold text-white mt-0.5">{{ $product->supplier->name ?? '-' }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-white/[0.03] border border-white/10">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Harga Beli</p>
                            <p class="font-semibold text-white mt-0.5">Rp{{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-white/[0.03] border border-white/10">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Harga Jual</p>
                            <p class="font-semibold text-white mt-0.5">Rp{{ number_format($product->selling_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 rounded-lg {{ $product->isLowStock() ? 'bg-red-500/[0.06] border border-red-500/20' : 'bg-emerald-500/[0.06] border border-emerald-500/20' }}">
                            <p class="text-xs font-medium uppercase tracking-wide {{ $product->isLowStock() ? 'text-red-400' : 'text-emerald-400' }}">Stok Saat Ini</p>
                            <p class="font-bold mt-0.5 flex items-center gap-1.5 {{ $product->isLowStock() ? 'text-red-300' : 'text-emerald-300' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $product->isLowStock() ? 'bg-red-500' : 'bg-emerald-500' }}"></span>
                                {{ $product->stock }}
                                @if($product->isLowStock())<span class="text-xs font-medium">(Menipis)</span>@endif
                            </p>
                        </div>
                        <div class="p-3 rounded-lg bg-white/[0.03] border border-white/10">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Stok Minimum</p>
                            <p class="font-semibold text-white mt-0.5">{{ $product->minimum_stock }}</p>
                        </div>
                    </div>

                    @if($product->description)
                    <div class="mt-4 p-4 rounded-lg bg-white/[0.03] border border-white/10">
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1">Deskripsi</p>
                        <p class="text-sm text-slate-300 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Atribut Produk --}}
            <div class="mt-8 pt-6 border-t border-white/10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 11V6a3 3 0 013-3z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-white">Atribut Produk</h3>
                </div>

                <div class="flex flex-wrap gap-2 mb-4">
                    @forelse($product->productAttributes as $attr)
                    <span class="inline-flex items-center gap-2 pl-3 pr-2 py-1.5 bg-indigo-500/10 text-indigo-300 rounded-full text-sm font-medium ring-1 ring-indigo-500/20">
                        {{ $attr->name }}: {{ $attr->value }}
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('product-attributes.destroy', [$attr->id, $product->id]) }}" method="POST" onsubmit="return confirm('Hapus atribut ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-4 h-4 flex items-center justify-center rounded-full hover:bg-indigo-500/30 text-indigo-400 hover:text-indigo-200 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                        @endif
                    </span>
                    @empty
                    <p class="text-slate-500 text-sm">Belum ada atribut untuk produk ini.</p>
                    @endforelse
                </div>

                @if(auth()->user()->isAdmin())
                <form action="{{ route('product-attributes.store') }}" method="POST" class="flex flex-wrap gap-3 items-end bg-white/[0.03] border border-white/10 rounded-lg p-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div>
                        <label class="block mb-1 text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama Atribut</label>
                        <input type="text" name="name" placeholder="Contoh: Warna, Kapasitas, Berat" class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-colors" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-semibold text-slate-500 uppercase tracking-wide">Nilai</label>
                        <input type="text" name="value" placeholder="Contoh: Merah, 5kg, 1 Liter" class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-colors" required>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-500 hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Tambah
                    </button>
                </form>
                <p class="text-xs text-slate-500 mt-2">Sesuaikan dengan jenis produk — misal "Voltase: 220V" untuk elektronik, "Volume: 1 Liter" untuk cairan, atau "Ukuran: XL" untuk pakaian.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
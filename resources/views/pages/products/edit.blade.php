@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-slate-300 mb-3 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali ke Produk
        </a>
        <p class="text-[11px] font-semibold text-blue-400 tracking-widest uppercase mb-1.5">Katalog Gudang</p>
        <h1 class="text-2xl font-bold text-white tracking-tight">Edit Produk</h1>
        <p class="text-sm text-slate-400 mt-1">Perbarui informasi <span class="font-medium text-slate-200">{{ $product->name }}</span>.</p>
    </div>

    @if($product->purchase_price < 1000 || $product->selling_price < 1000)
    <div class="mb-5 flex items-start gap-2.5 px-4 py-3 text-sm text-amber-300 rounded-xl bg-amber-500/10 border border-amber-500/20">
        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12V16.5zm9-4.5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>Harga produk ini terlihat sangat kecil (kemungkinan akibat bug input sebelumnya). Cek dan perbaiki angkanya di bawah jika tidak sesuai.</span>
    </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Section: Informasi Dasar --}}
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5">
                <h2 class="text-sm font-semibold text-white">Informasi Dasar</h2>
                <p class="text-xs text-slate-500 mt-0.5">Nama, kode, dan klasifikasi produk.</p>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-1.5 text-sm font-medium text-slate-300">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                        class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors" required>
                    @error('name') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sku" class="block mb-1.5 text-sm font-medium text-slate-300">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                        class="bg-white/5 border border-white/10 text-slate-100 text-sm font-mono rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors" required>
                    @error('sku') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block mb-1.5 text-sm font-medium text-slate-300">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors" required>
                        <option value="" class="bg-[#0B1220]">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="bg-[#0B1220]" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="supplier_id" class="block mb-1.5 text-sm font-medium text-slate-300">Supplier</label>
                    <select name="supplier_id" id="supplier_id"
                        class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors" required>
                        <option value="" class="bg-[#0B1220]">Pilih Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" class="bg-[#0B1220]" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="block mb-1.5 text-sm font-medium text-slate-300">Deskripsi <span class="text-slate-500 font-normal">(opsional)</span></label>
                    <textarea name="description" id="description" rows="3"
                        class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors">{{ old('description', $product->description) }}</textarea>
                    @error('description') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Section: Harga & Stok --}}
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5">
                <h2 class="text-sm font-semibold text-white">Harga & Stok</h2>
                <p class="text-xs text-slate-500 mt-0.5">Ketik angka biasa — pemisah ribuan otomatis muncul saat mengetik.</p>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- Harga Beli: auto-format Rupiah --}}
                <div x-data="{
                        raw: '{{ old('purchase_price', $product->purchase_price) }}',
                        display: '',
                        format() {
                            this.raw = this.display.replace(/\D/g, '');
                            this.display = this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                        }
                    }" x-init="display = raw ? new Intl.NumberFormat('id-ID').format(raw) : ''">
                    <label for="purchase_price_display" class="block mb-1.5 text-sm font-medium text-slate-300">Harga Beli</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500 pointer-events-none">Rp</span>
                        <input type="text" inputmode="numeric" id="purchase_price_display" x-model="display" @input="format()"
                            class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 pl-9 transition-colors"
                            placeholder="0" autocomplete="off">
                    </div>
                    <input type="hidden" name="purchase_price" :value="raw" required>
                    @error('purchase_price') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- Harga Jual: auto-format Rupiah --}}
                <div x-data="{
                        raw: '{{ old('selling_price', $product->selling_price) }}',
                        display: '',
                        format() {
                            this.raw = this.display.replace(/\D/g, '');
                            this.display = this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                        }
                    }" x-init="display = raw ? new Intl.NumberFormat('id-ID').format(raw) : ''">
                    <label for="selling_price_display" class="block mb-1.5 text-sm font-medium text-slate-300">Harga Jual</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500 pointer-events-none">Rp</span>
                        <input type="text" inputmode="numeric" id="selling_price_display" x-model="display" @input="format()"
                            class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 pl-9 transition-colors"
                            placeholder="0" autocomplete="off">
                    </div>
                    <input type="hidden" name="selling_price" :value="raw" required>
                    @error('selling_price') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="minimum_stock" class="block mb-1.5 text-sm font-medium text-slate-300">Stok Minimum</label>
                    <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}"
                        class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 block w-full p-3 transition-colors" required>
                    <p class="text-xs text-slate-500 mt-1.5">Sistem akan menandai "Stok Menipis" di bawah angka ini.</p>
                    @error('minimum_stock') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-end">
                    <div class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3">
                        <p class="text-xs text-slate-500 mb-0.5">Stok Saat Ini</p>
                        <p class="text-lg font-bold text-white">{{ $product->stock }} <span class="text-xs font-normal text-slate-500">unit</span></p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Diubah lewat menu Stok, bukan di sini.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Gambar --}}
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5">
                <h2 class="text-sm font-semibold text-white">Gambar Produk</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kosongkan bila tidak ingin mengganti gambar saat ini.</p>
            </div>
            <div class="p-6 flex flex-col sm:flex-row gap-5">
                @if($product->image)
                <div class="flex-shrink-0">
                    <p class="text-xs text-slate-500 mb-2">Gambar saat ini</p>
                    <img src="{{ asset('storage/'.$product->image) }}" class="w-28 h-28 rounded-xl object-cover border border-white/10">
                </div>
                @endif
                <div class="flex-1">
                    <label for="image" class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-white/10 rounded-xl py-8 h-full cursor-pointer hover:border-blue-500/40 hover:bg-blue-500/[0.03] transition-colors">
                        <svg class="w-7 h-7 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        <span class="text-sm text-slate-400"><span class="font-medium text-blue-400">Klik untuk ganti</span> gambar</span>
                        <span class="text-xs text-slate-500">PNG, JPG, hingga 2MB</span>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>
            @error('image') <p class="text-xs text-red-400 px-6 pb-4">{{ $message }}</p> @enderror
        </div>

        {{-- Aksi --}}
        <div class="flex items-center gap-3 pt-1">
            <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-500 shadow-sm shadow-blue-900/30 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('products.index') }}"
                class="px-5 py-2.5 text-sm font-medium text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
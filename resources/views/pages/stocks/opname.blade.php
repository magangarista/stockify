@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6 max-w-5xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('stock.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-white mb-3 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Riwayat Stok
        </a>
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">Stock Opname</h1>
                <p class="text-sm text-slate-400">Sesuaikan data sistem dengan hasil penghitungan fisik di gudang. Selisih tersimpan otomatis.</p>
            </div>
        </div>
    </div>

    <div
        x-data="{
            products: {{ $products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'sku' => $p->sku, 'stock' => $p->stock, 'image' => $p->image ? asset('storage/'.$p->image) : null])->values() }},
            selectedId: '',
            physical: '',
            get selected() { return this.products.find(p => p.id == this.selectedId) || null; },
            get difference() { return this.selected && this.physical !== '' ? (parseInt(this.physical) - this.selected.stock) : null; }
        }"
        class="grid grid-cols-1 lg:grid-cols-3 gap-6"
    >
        <!-- Form -->
        <div class="lg:col-span-2 bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="h-1 bg-indigo-500"></div>
            <form action="{{ route('stock.opname.store') }}" method="POST" class="p-6 sm:p-8 space-y-5">
                @csrf

                <div>
                    <label for="product_id" class="block mb-1.5 text-sm font-medium text-slate-300">Produk</label>
                    <select name="product_id" id="product_id" x-model="selectedId" class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 block w-full p-2.5" required>
                        <option value="" class="bg-[#0B1220]">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" class="bg-[#0B1220]">{{ $product->name }} ({{ $product->sku }})</option>
                        @endforeach
                    </select>
                    @error('product_id') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="physical_stock" class="block mb-1.5 text-sm font-medium text-slate-300">Stok Fisik (Hasil Hitung Manual)</label>
                    <div class="relative">
                        <input type="number" name="physical_stock" id="physical_stock" x-model="physical" min="0" class="bg-white/5 border border-white/10 text-slate-100 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 block w-full p-2.5 pr-14" required>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500">unit</span>
                    </div>
                    @error('physical_stock') <p class="text-sm text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="notes" class="block mb-1.5 text-sm font-medium text-slate-300">Catatan <span class="text-slate-500 font-normal">(opsional)</span></label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Contoh: penyebab selisih, kondisi barang, dsb." class="bg-white/5 border border-white/10 text-slate-100 placeholder-slate-500 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 block w-full p-2.5"></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500 shadow-sm shadow-indigo-900/30 transition-colors">Simpan Penyesuaian</button>
                    <a href="{{ route('stock.index') }}" class="px-6 py-2.5 text-sm font-medium text-slate-300 bg-white/5 border border-white/10 rounded-lg hover:bg-white/10 transition-colors">Batal</a>
                </div>
            </form>
        </div>

        <!-- Preview -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 bg-white/[0.03] border border-white/10 rounded-2xl shadow-sm p-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-4">Pratinjau Selisih</p>

                <template x-if="!selected">
                    <div class="py-10 text-center">
                        <svg class="w-10 h-10 mx-auto text-slate-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-sm text-slate-500">Pilih produk untuk melihat pratinjau selisih stok</p>
                    </div>
                </template>

                <template x-if="selected">
                    <div>
                        <div class="flex items-center gap-3 mb-5 pb-5 border-b border-white/10">
                            <template x-if="selected.image">
                                <img :src="selected.image" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                            </template>
                            <template x-if="!selected.image">
                                <div class="w-12 h-12 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0 text-slate-600 text-[10px]">No Image</div>
                            </template>
                            <div class="min-w-0">
                                <p class="font-semibold text-white truncate" x-text="selected.name"></p>
                                <p class="text-xs text-slate-500" x-text="'SKU: ' + selected.sku"></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-slate-400">Stok sistem</span>
                            <span class="font-semibold text-white tabular-nums" x-text="selected.stock"></span>
                        </div>
                        <div class="flex items-center justify-between text-sm mb-4">
                            <span class="text-slate-400">Stok fisik</span>
                            <span class="font-semibold text-white tabular-nums" x-text="physical !== '' ? physical : '-'"></span>
                        </div>

                        <template x-if="difference !== null">
                            <div class="flex items-center justify-between p-3 rounded-xl"
                                :class="difference > 0 ? 'bg-emerald-500/10 border border-emerald-500/20' : (difference < 0 ? 'bg-red-500/10 border border-red-500/20' : 'bg-white/5 border border-white/10')">
                                <span class="text-sm font-medium" :class="difference > 0 ? 'text-emerald-300' : (difference < 0 ? 'text-red-300' : 'text-slate-500')">
                                    <span x-text="difference > 0 ? 'Stok bertambah' : (difference < 0 ? 'Stok berkurang' : 'Tidak ada selisih')"></span>
                                </span>
                                <span class="text-lg font-bold tabular-nums" :class="difference > 0 ? 'text-emerald-400' : (difference < 0 ? 'text-red-400' : 'text-slate-600')" x-text="(difference > 0 ? '+' : '') + difference"></span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection
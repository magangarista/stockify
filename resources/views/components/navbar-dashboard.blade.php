<nav class="fixed z-50 top-4 inset-x-4 lg:inset-x-6 bg-[#0B1220]/95 backdrop-blur border border-white/10 rounded-2xl shadow-xl shadow-black/20">
    <div class="px-3 py-3 lg:px-4">
      <div class="flex items-center justify-between gap-4">

        <!-- Logo box -->
        <div class="flex items-center gap-3 flex-shrink-0">
          <button
            id="toggleSidebarMobile"
            type="button"
            x-data
            @click="$store.sidebar.toggle()"
            class="p-2 text-slate-400 rounded-lg hover:text-white hover:bg-white/10">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
          </button>

          <a href="{{ url('/') }}" class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
              <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
            </div>
            <span class="hidden sm:block text-lg font-bold text-white tracking-tight">Stockify</span>
          </a>
        </div>

        <!-- Search pill -->
        <div class="hidden lg:flex flex-1 max-w-md" x-data="{
    query: '',
    results: [],
    open: false,
    async search() {
        if (this.query.length < 2) { this.results = []; this.open = false; return; }
        const res = await fetch(`{{ route('search.products') }}?q=${encodeURIComponent(this.query)}`);
        this.results = await res.json();
        this.open = this.results.length > 0;
    }
}" @click.outside="open = false">
          <div class="relative w-full">
            <input
              type="text"
              x-model="query"
              @input.debounce.300ms="search()"
              @focus="if(results.length) open = true"
              autocomplete="off"
              class="bg-white/5 border border-white/10 text-white placeholder-slate-500 text-sm rounded-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-4 pr-10 py-2.5"
              placeholder="Cari produk...">
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
              <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>

            <div x-show="open" x-cloak class="absolute z-50 w-full mt-2 bg-[#0f1830] border border-white/10 rounded-xl shadow-lg max-h-80 overflow-y-auto">
            <template x-for="product in results" :key="product.id">
              <a :href="`/products/${product.id}`" class="flex items-center gap-3 px-4 py-2 hover:bg-white/5 border-b border-white/5 last:border-b-0">
                <template x-if="product.image">
                  <img :src="`/storage/${product.image}`" class="w-8 h-8 rounded object-cover">
                </template>
                <div>
                  <div class="text-sm font-medium text-white" x-text="product.name"></div>
                  <div class="text-xs text-slate-400">SKU: <span x-text="product.sku"></span> · Stok: <span x-text="product.stock"></span></div>
                </div>
              </a>
            </template>
          </div>
          </div>
        </div>

        <!-- Quick link pills -->
        <div class="hidden xl:flex items-center gap-1 flex-shrink-0">
          <a href="{{ route('products.index') }}" class="px-3.5 py-2 text-sm font-medium rounded-full transition-colors {{ request()->routeIs('products.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Produk</a>
          <a href="{{ route('stock.index') }}" class="px-3.5 py-2 text-sm font-medium rounded-full transition-colors {{ request()->routeIs('stock.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Stok</a>
          <a href="{{ route('reports.stock') }}" class="px-3.5 py-2 text-sm font-medium rounded-full transition-colors {{ request()->routeIs('reports.*') ? 'bg-blue-500/15 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Laporan</a>
        </div>

        <!-- Right icon buttons -->
        <div class="flex items-center gap-2 flex-shrink-0">

            <button id="toggleSidebarMobileSearch" type="button" class="p-2.5 text-slate-400 rounded-full lg:hidden hover:text-white hover:bg-white/10">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </button>

            <!-- Notifications -->
            <button type="button" data-dropdown-toggle="notification-dropdown" class="relative p-2.5 rounded-full bg-purple-500/15 text-purple-400 hover:bg-purple-500/25 transition-colors">
              <span class="sr-only">Notifikasi</span>
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
              <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-[#0B1220]"></span>
            </button>
            <div class="z-20 z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-[#0f1830] border border-white/10 divide-y divide-white/10 rounded-xl shadow-2xl" id="notification-dropdown">
              <div class="block px-4 py-3 text-sm font-semibold text-center text-white bg-white/5">Notifikasi</div>
              <div>
                <a href="{{ route('products.index') }}" class="flex px-4 py-3 border-b border-white/5 hover:bg-white/5">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-red-500/15">
                      <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    </div>
                  </div>
                  <div class="w-full pl-3">
                      <div class="text-slate-400 font-normal text-sm mb-1.5">Stok <span class="font-semibold text-white">Keyboard dan Mouse Wireless</span> menipis, sisa <span class="font-semibold text-white">3 unit</span></div>
                      <div class="text-xs font-medium text-blue-400">5 menit yang lalu</div>
                  </div>
                </a>
                <a href="{{ route('stock.index') }}" class="flex px-4 py-3 border-b border-white/5 hover:bg-white/5">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-green-500/15">
                      <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd"></path></svg>
                    </div>
                  </div>
                  <div class="w-full pl-3">
                      <div class="text-slate-400 font-normal text-sm mb-1.5">Barang masuk <span class="font-semibold text-white">15 unit Keyboard dan Mouse Wireless</span> berhasil dicatat</div>
                      <div class="text-xs font-medium text-blue-400">1 jam yang lalu</div>
                  </div>
                </a>
              </div>
              <a href="{{ route('reports.stock') }}" class="block py-2.5 text-sm font-medium text-center text-slate-300 bg-white/5 hover:bg-white/10">
                  <div class="inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                    Lihat semua
                  </div>
              </a>
            </div>

            <!-- Apps / Settings -->
            <button type="button" data-dropdown-toggle="apps-dropdown" class="p-2.5 rounded-full bg-white/10 text-slate-300 hover:bg-white/20 hover:text-white transition-colors">
              <span class="sr-only">Menu cepat</span>
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </button>
            <div class="z-20 z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-[#0f1830] border border-white/10 divide-y divide-white/10 rounded-xl shadow-2xl" id="apps-dropdown">
              <div class="block px-4 py-3 text-sm font-semibold text-center text-white bg-white/5">Menu Cepat</div>
              <div class="grid grid-cols-3 gap-2 p-4">
                <a href="{{ route('products.index') }}" class="block p-3 text-center rounded-lg hover:bg-white/5">
                  <svg class="mx-auto mb-1 text-slate-400 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path><path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                  <div class="text-xs font-medium text-slate-200">Produk</div>
                </a>
                <a href="{{ route('categories.index') }}" class="block p-3 text-center rounded-lg hover:bg-white/5">
                  <svg class="mx-auto mb-1 text-slate-400 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd"></path></svg>
                  <div class="text-xs font-medium text-slate-200">Kategori</div>
                </a>
                <a href="{{ route('suppliers.index') }}" class="block p-3 text-center rounded-lg hover:bg-white/5">
                  <svg class="mx-auto mb-1 text-slate-400 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                  <div class="text-xs font-medium text-slate-200">Supplier</div>
                </a>
                <a href="{{ route('stock.index') }}" class="block p-3 text-center rounded-lg hover:bg-white/5">
                  <svg class="mx-auto mb-1 text-slate-400 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd"></path></svg>
                  <div class="text-xs font-medium text-slate-200">Stok</div>
                </a>
                <a href="{{ route('reports.stock') }}" class="block p-3 text-center rounded-lg hover:bg-white/5">
                  <svg class="mx-auto mb-1 text-slate-400 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                  <div class="text-xs font-medium text-slate-200">Laporan</div>
                </a>
                @auth
                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" class="block p-3 text-center rounded-lg hover:bg-white/5">
                  <svg class="mx-auto mb-1 text-slate-400 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                  <div class="text-xs font-medium text-slate-200">Pengguna</div>
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="block">
                  @csrf
                  <button type="submit" class="block w-full p-3 text-center rounded-lg hover:bg-white/5">
                    <svg class="mx-auto mb-1 text-slate-400 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                      <div class="text-xs font-medium text-slate-200">Logout</div>
                  </button>
                </form>
                @endauth
              </div>
            </div>

            <!-- Profile -->
            <div class="flex items-center">
              <button type="button" class="flex text-sm rounded-full ring-2 ring-white/10 hover:ring-blue-500/50 transition-all" id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
                <span class="sr-only">Open user menu</span>
                @if(auth()->user()->avatar)
                <img class="w-9 h-9 rounded-full object-cover" src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="user photo">
                @else
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                @endif
              </button>
              <div class="z-50 hidden my-4 text-base list-none bg-[#0f1830] border border-white/10 divide-y divide-white/10 rounded-xl shadow-2xl" id="dropdown-2">
                @auth
                <div class="px-5 py-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        </span>
                          </div>
                          <div class="flex-1">
                              <h4 class="text-white font-semibold leading-none">
                                  {{ auth()->user()->name }}
                              </h4>
                      <p class="text-xs text-slate-400 mt-1">
                          Administrator Stockify
                          </p>
                          <span class="inline-flex items-center mt-2 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-medium">
                              ● Online
                          </span>
                      </div>
                  </div>
              </div>
                <ul class="py-2">

    <li>
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition">

            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7m-9 9V9m0 12h6"/>
            </svg>

            Dashboard
        </a>
    </li>

    <li>
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition">

            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10.325 4.317a1.724 1.724 0 013.35 0 1.724 1.724 0 002.573 1.066 1.724 1.724 0 012.37 2.37 1.724 1.724 0 001.065 2.572 1.724 1.724 0 010 3.35 1.724 1.724 0 00-1.066 2.573 1.724 1.724 0 01-2.37 2.37 1.724 1.724 0 00-2.572 1.065 1.724 1.724 0 01-3.35 0 1.724 1.724 0 00-2.573-1.066 1.724 1.724 0 01-2.37-2.37 1.724 1.724 0 00-1.065-2.572 1.724 1.724 0 010-3.35 1.724 1.724 0 001.066-2.573 1.724 1.724 0 012.37-2.37 1.724 1.724 0 002.572-1.065z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>

            Settings
        </a>
    </li>

    <li class="border-t border-white/10 mt-2 pt-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H9"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M13 20H6a2 2 0 01-2-2V6a2 2 0 012-2h7"/>
                        </svg>
                             Logout
                           </button>
                        </form>
                      </li>
                    </ul>
                @endauth
              </div>
            </div>
        </div>

      </div>
    </div>
  </nav>
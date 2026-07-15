@php
    $url = explode('/', request()->url());
    $page_slug = $url[count($url) - 2];
@endphp

<aside
    id="sidebar"
    x-data
    x-show="$store.sidebar.open"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-64 h-full pt-28 font-normal"
    aria-label="Sidebar"
>
  <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-[#0B1220] border-r border-white/5 rounded-tr-2xl overflow-hidden">
    <div class="flex flex-col flex-1 pt-4 pb-4 overflow-y-auto">
      <div class="flex-1 px-3 space-y-1">
        <ul class="pb-2 space-y-1">
            {{ $slot }}
        </ul>
      </div>
    </div>
    <div class="px-3 py-4 border-t border-white/5">
        <p class="text-xs font-semibold text-slate-300 text-center">Stockify Admin Dashboard</p>
        <p class="text-xs text-slate-500 text-center mt-0.5">&copy; {{ date('Y') }} All Rights Reserved</p>
    </div>
  </div>
</aside>

<div
    x-data
    x-show="$store.sidebar.open"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="$store.sidebar.close()"
    class="fixed inset-0 z-10 bg-gray-900/50 lg:hidden"
    id="sidebarBackdrop"
></div>
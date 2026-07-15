@props(['icon' => null, 'routeName' => null, 'title' => null])
<li x-data="{ open: {{ request()->routeIs($routeName) ? 'true' : 'false' }} }">
    <button type="button" @click="open = !open"
        class="flex items-center w-full gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
        {{ request()->routeIs($routeName) ? 'text-white font-semibold' : 'text-slate-400 hover:bg-white/5 hover:text-white font-medium' }}">
        <span class="w-5 h-5 flex items-center justify-center flex-shrink-0 {{ request()->routeIs($routeName) ? 'text-blue-400' : 'text-slate-500' }}">
            @if($icon)
                {{ $icon }}
            @else
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
            @endif
        </span>
        <span class="flex-1 text-left">{{ $title }}</span>
        <svg class="w-4 h-4 text-slate-500 transition-transform duration-200" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
    <ul x-show="open" x-collapse class="mt-1 ml-4 pl-4 space-y-0.5 border-l border-white/10">
        {{ $slot }}
    </ul>
</li>
@props(['icon' => null, 'routeName' => null, 'title' => null])
<li>
    <a href="{{ route($routeName) }}"
        class="flex items-center gap-2.5 pl-2 pr-3 py-2 rounded-lg text-sm transition-colors
        {{ request()->routeIs($routeName)
            ? 'text-white font-semibold'
            : 'text-slate-400 hover:text-white font-medium' }}">
        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ request()->routeIs($routeName) ? 'bg-blue-400' : 'bg-slate-600' }}"></span>
        {{ $title }}
    </a>
</li>
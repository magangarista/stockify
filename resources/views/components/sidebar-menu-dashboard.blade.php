@props(['icon' => null, 'routeName' => null, 'title' => null])
<li>
    <a href="{{ route($routeName) }}"
        class="flex items-center p-2 text-base rounded-lg group transition-colors border-l-2
        {{ request()->routeIs($routeName)
            ? 'bg-white/5 text-white border-amber-400 font-medium'
            : 'text-gray-400 border-transparent hover:bg-white/5 hover:text-white' }}">
        {{ $icon }}
        <span class="ml-3" sidebar-toggle-item> {{ $title }} </span>
    </a>
</li>

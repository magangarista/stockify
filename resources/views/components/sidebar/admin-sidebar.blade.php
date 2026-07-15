<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="dashboard" title="Dashboard"/>
    <x-sidebar-menu-dashboard routeName="products.index" title="Produk"/>
    <x-sidebar-menu-dashboard routeName="categories.index" title="Kategori"/>
    <x-sidebar-menu-dashboard routeName="suppliers.index" title="Supplier"/>
    <x-sidebar-menu-dashboard routeName="stock.index" title="Stok"/>
    @if(auth()->user()->isAdmin())
    <x-sidebar-menu-dashboard routeName="users.index" title="Pengguna"/>
    @endif
    <x-sidebar-menu-dropdown-dashboard routeName="reports.*" title="Laporan">
        <x-sidebar-menu-dropdown-item-dashboard routeName="reports.stock" title="Laporan Stok"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="reports.transactions" title="Laporan Transaksi"/>
        @if(auth()->user()->isAdmin())
        <x-sidebar-menu-dropdown-item-dashboard routeName="reports.activity" title="Aktivitas Pengguna"/>
        @endif
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>
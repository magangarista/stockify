<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return match ($user->role) {
            'Admin' => $this->adminDashboard(),
            'Manajer Gudang' => $this->manajerDashboard(),
            'Staff Gudang' => $this->staffDashboard(),
            default => redirect('/login'),
        };
    }
    protected function adminDashboard()
    {
        $totalProducts = Product::count();
        $totalStockIn = StockTransaction::where('type', 'in')->whereDate('date', today())->sum('quantity');
        $totalStockOut = StockTransaction::where('type', 'out')->whereDate('date', today())->sum('quantity');
        $totalUsers = User::count();
        $recentTransactions = StockTransaction::with('product', 'user')->latest()->take(5)->get();
        // Data untuk grafik stok per kategori
        $stockByCategory = Category::withSum('products', 'stock')->get();
        $chartLabels = $stockByCategory->pluck('name');
        $chartData = $stockByCategory->pluck('products_sum_stock')->map(fn ($v) => $v ?? 0);

        // Data tren barang masuk & keluar 7 hari terakhir (untuk grafik garis)
        $trendLabels = collect();
        $trendIn = collect();
        $trendOut = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $trendLabels->push($date->translatedFormat('d M'));
            $trendIn->push((int) StockTransaction::where('type', 'in')->whereDate('date', $date)->sum('quantity'));
            $trendOut->push((int) StockTransaction::where('type', 'out')->whereDate('date', $date)->sum('quantity'));
        }

        return view('pages.dashboard.admin', compact(
            'totalProducts', 'totalStockIn', 'totalStockOut', 'totalUsers', 'recentTransactions',
            'chartLabels', 'chartData', 'trendLabels', 'trendIn', 'trendOut'
        ));
    }
    protected function manajerDashboard()
    {
        $lowStockProducts = Product::whereColumn('stock', '<=', 'minimum_stock')->get();
        $stockInToday = StockTransaction::where('type', 'in')->whereDate('date', today())->sum('quantity');
        $stockOutToday = StockTransaction::where('type', 'out')->whereDate('date', today())->sum('quantity');
        return view('pages.dashboard.manajer', compact('lowStockProducts', 'stockInToday', 'stockOutToday'));
    }
    protected function staffDashboard()
    {
        $pendingIn = StockTransaction::where('type', 'in')->where('status', 'pending')->with('product')->get();
        $pendingOut = StockTransaction::where('type', 'out')->where('status', 'pending')->with('product')->get();
        return view('pages.dashboard.staff', compact('pendingIn', 'pendingOut'));
    }
}
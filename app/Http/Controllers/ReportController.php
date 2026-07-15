<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stock(Request $request)
    {
        $products = Product::with('category')->get();
        return view('pages.reports.stock', compact('products'));
    }

    public function transactions(Request $request)
    {
        $query = StockTransaction::with('product', 'user');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();

        return view('pages.reports.transactions', compact('transactions'));
    }

    public function activity(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->paginate(20)->withQueryString();
        $users = User::all();

        return view('pages.reports.activity', compact('logs', 'users'));
    }
}
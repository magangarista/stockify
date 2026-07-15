<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockInRequest;
use App\Http\Requests\StoreStockOutRequest;
use App\Http\Requests\StoreStockOpnameRequest;
use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\StockTransactionService;
use Illuminate\Validation\ValidationException;

class StockTransactionController extends Controller
{
    public function __construct(protected StockTransactionService $stockService)
    {
        $this->middleware('role:Admin,Manajer Gudang')->only(['createIn', 'storeIn', 'createOut', 'storeOut', 'opnameForm', 'storeOpname']);
        $this->middleware('role:Admin,Staff Gudang')->only(['confirmIn', 'confirmOut']);
    }

    public function index()
    {
        $transactions = $this->stockService->getPaginatedTransactions(15);
        return view('pages.stocks.index', compact('transactions'));
    }

    public function createIn()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('pages.stocks.create-in', compact('products', 'suppliers'));
    }

    public function storeIn(StoreStockInRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $this->stockService->recordStockIn($data);

        $product = Product::find($data['product_id']);
        ActivityLog::record('create_stock_in', "Mencatat rencana barang masuk: {$product->name} ({$data['quantity']} unit)");

        return redirect()->route('stock.index')->with('success', 'Rencana barang masuk berhasil dicatat, menunggu konfirmasi Staff Gudang.');
    }

    public function createOut()
    {
        $products = Product::all();
        return view('pages.stocks.create-out', compact('products'));
    }

    public function storeOut(StoreStockOutRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        try {
            $this->stockService->recordStockOut($data);

            $product = Product::find($data['product_id']);
            ActivityLog::record('create_stock_out', "Mencatat rencana barang keluar: {$product->name} ({$data['quantity']} unit)");

            return redirect()->route('stock.index')->with('success', 'Rencana barang keluar berhasil dicatat, menunggu konfirmasi Staff Gudang.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function opnameForm()
    {
        $products = Product::all();
        return view('pages.stocks.opname', compact('products'));
    }

    public function storeOpname(StoreStockOpnameRequest $request)
    {
        $data = $request->validated();

        $this->stockService->recordStockOpname(
            $data['product_id'],
            $data['physical_stock'],
            auth()->id(),
            $data['notes'] ?? null
        );

        $product = Product::find($data['product_id']);
        ActivityLog::record('stock_opname', "Melakukan stock opname pada: {$product->name}, stok fisik: {$data['physical_stock']}");

        return redirect()->route('stock.index')->with('success', 'Stock opname berhasil disimpan, stok telah disesuaikan.');
    }

    public function confirmIn(int $id)
    {
        $transaction = $this->stockService->confirmStockIn($id);

        ActivityLog::record('confirm_stock_in', "Mengonfirmasi barang masuk: {$transaction->product->name} ({$transaction->quantity} unit)");

        return redirect()->route('dashboard')->with('success', 'Barang masuk berhasil dikonfirmasi, stok telah diperbarui.');
    }

    public function confirmOut(int $id)
    {
        try {
            $transaction = $this->stockService->confirmStockOut($id);

            ActivityLog::record('confirm_stock_out', "Mengonfirmasi barang keluar: {$transaction->product->name} ({$transaction->quantity} unit)");

            return redirect()->route('dashboard')->with('success', 'Barang keluar berhasil dikonfirmasi, stok telah diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}
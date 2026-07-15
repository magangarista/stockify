<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockTransactionService
{
    public function __construct(protected StockTransactionRepositoryInterface $stockRepository)
    {
    }

    public function getPaginatedTransactions(int $perPage = 10, ?string $type = null)
    {
        return $this->stockRepository->paginate($perPage, $type);
    }

    public function getTransactionDetail(int $id)
    {
        return $this->stockRepository->find($id);
    }

    /**
     * Manajer Gudang mencatat rencana barang masuk. Status pending, stok BELUM berubah.
     */
    public function recordStockIn(array $data): mixed
    {
        return $this->stockRepository->create([
            'product_id' => $data['product_id'],
            'user_id' => $data['user_id'],
            'type' => 'in',
            'quantity' => $data['quantity'],
            'date' => $data['date'],
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * Manajer Gudang mencatat rencana barang keluar. Status pending, stok BELUM berubah.
     */
    public function recordStockOut(array $data): mixed
    {
        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < $data['quantity']) {
            throw ValidationException::withMessages([
                'quantity' => "Stok tidak mencukupi. Stok tersedia: {$product->stock}.",
            ]);
        }

        return $this->stockRepository->create([
            'product_id' => $product->id,
            'user_id' => $data['user_id'],
            'type' => 'out',
            'quantity' => $data['quantity'],
            'date' => $data['date'],
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * Staff Gudang mengonfirmasi barang masuk yang sudah diperiksa fisiknya.
     * Di sinilah stok produk benar-benar bertambah.
     */
    public function confirmStockIn(int $transactionId): mixed
    {
        return DB::transaction(function () use ($transactionId) {
            $transaction = StockTransaction::where('type', 'in')
                ->where('status', 'pending')
                ->findOrFail($transactionId);

            $transaction->update(['status' => 'confirmed']);
            $transaction->product->increment('stock', $transaction->quantity);

            return $transaction;
        });
    }

    /**
     * Staff Gudang mengonfirmasi barang keluar yang sudah disiapkan/dikirim.
     * Di sinilah stok produk benar-benar berkurang.
     */
    public function confirmStockOut(int $transactionId): mixed
    {
        return DB::transaction(function () use ($transactionId) {
            $transaction = StockTransaction::where('type', 'out')
                ->where('status', 'pending')
                ->findOrFail($transactionId);

            $product = $transaction->product;

            if ($product->stock < $transaction->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => "Stok tidak mencukupi untuk konfirmasi. Stok tersedia: {$product->stock}.",
                ]);
            }

            $transaction->update(['status' => 'confirmed']);
            $product->decrement('stock', $transaction->quantity);

            return $transaction;
        });
    }

    /**
     * Stock Opname tetap langsung final (bukan alur pending), karena ini penyesuaian
     * berdasarkan hitung fisik langsung oleh yang berwenang.
     */
    public function recordStockOpname(int $productId, int $physicalStock, int $userId, ?string $notes = null)
    {
        return DB::transaction(function () use ($productId, $physicalStock, $userId, $notes) {
            $product = Product::findOrFail($productId);
            $difference = $physicalStock - $product->stock;

            if ($difference === 0) {
                return null;
            }

            $transaction = $this->stockRepository->create([
                'product_id' => $product->id,
                'user_id' => $userId,
                'type' => $difference > 0 ? 'in' : 'out',
                'quantity' => abs($difference),
                'date' => now()->toDateString(),
                'status' => 'confirmed',
                'notes' => 'Stock Opname: ' . ($notes ?? 'Penyesuaian stok fisik'),
            ]);

            $product->update(['stock' => $physicalStock]);

            return $transaction;
        });
    }
}
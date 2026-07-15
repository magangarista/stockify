<?php

namespace App\Repositories;

use App\Models\StockTransaction;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;

class StockTransactionRepository implements StockTransactionRepositoryInterface
{
    public function __construct(protected StockTransaction $model)
    {
    }

    public function paginate(int $perPage = 10, ?string $type = null)
    {
        $query = $this->model->with('product', 'user')->latest();

        if ($type) {
            $query->where('type', $type);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->with('product', 'user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function updateStatus(int $id, string $status)
    {
        $transaction = $this->model->findOrFail($id);
        $transaction->update(['status' => $status]);
        return $transaction;
    }
}
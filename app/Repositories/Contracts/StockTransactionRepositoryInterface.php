<?php

namespace App\Repositories\Contracts;

interface StockTransactionRepositoryInterface
{
    public function paginate(int $perPage = 10, ?string $type = null);
    public function find(int $id);
    public function create(array $data);
    public function updateStatus(int $id, string $status);
}
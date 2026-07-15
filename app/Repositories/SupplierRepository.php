<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function __construct(protected Supplier $model)
    {
    }

    public function all()
    {
        return $this->model->withCount('products')->get();
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->withCount('products')->latest()->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $supplier = $this->model->findOrFail($id);
        $supplier->update($data);
        return $supplier;
    }

    public function delete(int $id)
    {
        $supplier = $this->model->findOrFail($id);
        return $supplier->delete();
    }
}
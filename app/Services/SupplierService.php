<?php

namespace App\Services;

use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Validation\ValidationException;

class SupplierService
{
    public function __construct(protected SupplierRepositoryInterface $supplierRepository)
    {
    }

    public function getAllSuppliers()
    {
        return $this->supplierRepository->all();
    }

    public function getPaginatedSuppliers(int $perPage = 10)
    {
        return $this->supplierRepository->paginate($perPage);
    }

    public function getSupplierDetail(int $id)
    {
        return $this->supplierRepository->find($id);
    }

    public function createSupplier(array $data)
    {
        return $this->supplierRepository->create($data);
    }

    public function updateSupplier(int $id, array $data)
    {
        return $this->supplierRepository->update($id, $data);
    }

    public function deleteSupplier(int $id)
    {
        $supplier = $this->supplierRepository->find($id);

        if ($supplier->products()->exists()) {
            throw ValidationException::withMessages([
                'supplier' => 'Supplier tidak dapat dihapus karena masih memiliki produk terkait.',
            ]);
        }

        return $this->supplierRepository->delete($id);
    }
}
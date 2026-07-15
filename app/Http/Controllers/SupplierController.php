<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\ActivityLog;
use App\Services\SupplierService;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    public function __construct(protected SupplierService $supplierService)
    {
        $this->middleware('role:Admin')->except(['index']);
    }

    public function index()
    {
        $suppliers = $this->supplierService->getPaginatedSuppliers(10);
        return view('pages.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('pages.suppliers.create');
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = $this->supplierService->createSupplier($request->validated());

        ActivityLog::record('create_supplier', "Menambahkan supplier: {$supplier->name}");

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $supplier = $this->supplierService->getSupplierDetail($id);
        return view('pages.suppliers.edit', compact('supplier'));
    }

    public function update(UpdateSupplierRequest $request, int $id)
    {
        $this->supplierService->updateSupplier($id, $request->validated());

        $supplier = $this->supplierService->getSupplierDetail($id);
        ActivityLog::record('update_supplier', "Mengubah supplier: {$supplier->name}");

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        try {
            $supplier = $this->supplierService->getSupplierDetail($id);
            ActivityLog::record('delete_supplier', "Menghapus supplier: {$supplier->name}");

            $this->supplierService->deleteSupplier($id);
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
        } catch (ValidationException $e) {
            return redirect()->route('suppliers.index')->with('error', $e->getMessage());
        }
    }
}
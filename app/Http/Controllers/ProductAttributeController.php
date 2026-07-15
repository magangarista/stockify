<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductAttributeRequest;
use App\Services\ProductAttributeService;

class ProductAttributeController extends Controller
{
    public function __construct(protected ProductAttributeService $attributeService)
    {
        $this->middleware('role:Admin');
    }

    public function store(StoreProductAttributeRequest $request)
    {
        $data = $request->validated();

        $this->attributeService->addAttribute($data['product_id'], $data['name'], $data['value']);

        return redirect()->route('products.show', $data['product_id'])->with('success', 'Atribut berhasil ditambahkan.');
    }

    public function destroy(int $id, int $productId)
    {
        $this->attributeService->deleteAttribute($id);

        return redirect()->route('products.show', $productId)->with('success', 'Atribut berhasil dihapus.');
    }
}
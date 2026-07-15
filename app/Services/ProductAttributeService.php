<?php

namespace App\Services;

use App\Repositories\Contracts\ProductAttributeRepositoryInterface;

class ProductAttributeService
{
    public function __construct(protected ProductAttributeRepositoryInterface $attributeRepository)
    {
    }

    public function addAttribute(int $productId, string $name, string $value)
    {
        return $this->attributeRepository->create([
            'product_id' => $productId,
            'name' => $name,
            'value' => $value,
        ]);
    }

    public function deleteAttribute(int $id)
    {
        return $this->attributeRepository->delete($id);
    }
}
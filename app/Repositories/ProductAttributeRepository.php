<?php

namespace App\Repositories;

use App\Models\ProductAttribute;
use App\Repositories\Contracts\ProductAttributeRepositoryInterface;

class ProductAttributeRepository implements ProductAttributeRepositoryInterface
{
    public function __construct(protected ProductAttribute $model)
    {
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function delete(int $id)
    {
        $attribute = $this->model->findOrFail($id);
        return $attribute->delete();
    }
}
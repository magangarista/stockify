<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(protected Category $model)
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
        $category = $this->model->findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->model->findOrFail($id);
        return $category->delete();
    }
}
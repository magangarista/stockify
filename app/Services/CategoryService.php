<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function __construct(protected CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    public function getPaginatedCategories(int $perPage = 10)
    {
        return $this->categoryRepository->paginate($perPage);
    }

    public function getCategoryDetail(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id)
    {
        $category = $this->categoryRepository->find($id);

        // Business rule: kategori yang masih punya produk tidak boleh dihapus
        if ($category->products()->exists()) {
            throw ValidationException::withMessages([
                'category' => 'Kategori tidak dapat dihapus karena masih memiliki produk terkait.',
            ]);
        }

        return $this->categoryRepository->delete($id);
    }
}
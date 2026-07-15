<?php
namespace App\Repositories;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(protected Product $model)
    {
    }
    public function all()
    {
        return $this->model->with('category', 'supplier')->get();
    }
    public function paginate(int $perPage = 10, ?int $categoryId = null)
    {
        return $this->model->with('category', 'supplier')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
    public function find(int $id)
    {
        return $this->model->with('category', 'supplier', 'productAttributes')->findOrFail($id);
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function update(int $id, array $data)
    {
        $product = $this->model->findOrFail($id);
        $product->update($data);
        return $product;
    }
    public function delete(int $id)
    {
        $product = $this->model->findOrFail($id);
        return $product->delete();
    }
    public function findBySku(string $sku)
    {
        return $this->model->where('sku', $sku)->first();
    }
}
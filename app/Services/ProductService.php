<?php
namespace App\Services;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class ProductService
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }
    public function getAllProducts()
    {
        return $this->productRepository->all();
    }
    public function getPaginatedProducts(int $perPage = 10, ?int $categoryId = null)
    {
        return $this->productRepository->paginate($perPage, $categoryId);
    }
    public function getProductDetail(int $id)
    {
        return $this->productRepository->find($id);
    }
    public function createProduct(array $data, ?UploadedFile $image = null)
    {
        if ($image) {
            $data['image'] = $image->store('products', 'public');
        }
        // Business logic: stok awal = 0 jika tidak diisi
        $data['stock'] = $data['stock'] ?? 0;
        return $this->productRepository->create($data);
    }
    public function updateProduct(int $id, array $data, ?UploadedFile $image = null)
    {
        if ($image) {
            $product = $this->productRepository->find($id);
            // Hapus gambar lama kalau ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $image->store('products', 'public');
        }
        return $this->productRepository->update($id, $data);
    }
    public function deleteProduct(int $id)
    {
        $product = $this->productRepository->find($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        return $this->productRepository->delete($id);
    }
    public function isSkuTaken(string $sku, ?int $exceptId = null): bool
    {
        $product = $this->productRepository->findBySku($sku);
        if (! $product) {
            return false;
        }
        return $exceptId ? $product->id !== $exceptId : true;
    }
}
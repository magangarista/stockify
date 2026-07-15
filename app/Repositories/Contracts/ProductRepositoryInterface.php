<?php
namespace App\Repositories\Contracts;
interface ProductRepositoryInterface
{
    public function all();
    public function paginate(int $perPage = 10, ?int $categoryId = null);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function findBySku(string $sku);
}
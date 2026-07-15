<?php

namespace App\Repositories\Contracts;

interface ProductAttributeRepositoryInterface
{
    public function create(array $data);
    public function delete(int $id);
}
<?php

namespace App\Repositories;

use App\Models\Supplier;

interface SupplierRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 10, int $page = 1);
    public function findById(int $id): ?Supplier;
    public function create(array $data): Supplier;
    public function update(int $id, array $data): Supplier;
    public function delete(int $id): bool;
}

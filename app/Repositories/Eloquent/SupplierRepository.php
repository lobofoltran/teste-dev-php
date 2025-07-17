<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 10, int $page = 1)
    {
        $query = Supplier::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('document', 'like', "%{$filters['search']}%");
        }

        return $query->orderBy('created_at', 'asc')
                     ->paginate($perPage, ['*'], 'page', $page);
    }

    public function findById(int $id): ?Supplier
    {
        return Supplier::find($id);
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(int $id, array $data): Supplier
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);
        return $supplier;
    }

    public function delete(int $id): bool
    {
        $supplier = Supplier::findOrFail($id);
        return $supplier->delete();
    }
}

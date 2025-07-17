<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\SupplierRepositoryInterface;
use App\Services\CnpjService;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepository,
        private CnpjService $cnpjService
    ) {
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->query('search')
        ];

        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);

        $suppliers = $this->supplierRepository->all($filters, $perPage, $page);

        return response()->json($suppliers);
    }

    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();
        
        $document = $data['document'];

        if ($this->cnpjService->isCnpj($document)) {
            $cnpjData = $this->cnpjService->fetch($document);

            if ($cnpjData) {
                $data['name'] = $cnpjData['razao_social'] ?? $data['name'];
                $data['address'] = $this->cnpjService->formatAddress($cnpjData);
            }
        }

        $supplier = $this->supplierRepository->create($data);

        return response()->json($supplier, 201);
    }

    public function show($id)
    {
        $supplier = $this->supplierRepository->findById($id);

        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        return response()->json($supplier);
    }

    public function update(UpdateSupplierRequest $request, $id)
    {
        $supplier = $this->supplierRepository->update($id, $request->validated());

        return response()->json($supplier);
    }

    public function destroy($id)
    {
        $this->supplierRepository->delete($id);

        return response()->json(['message' => 'Supplier deleted successfully.']);
    }
}


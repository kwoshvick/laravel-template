<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SuplierStoreRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class SupplierController extends Controller
{
    private SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function create(SuplierStoreRequest $request): JsonResponse
    {
        $this->supplierService->upload_csv($request->validated(), $request);

        return Response::Json('Processing', 201);
    }

    public function list(): JsonResponse
    {

        return Response::Json(Supplier::all());
    }
}

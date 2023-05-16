<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SupermarketStoreRequest;
use App\Http\Requests\SupermarketUpdateRequest;
use App\Http\Resources\SupermarketCollection;
use App\Http\Resources\SupermarketResource;
use App\Models\Supermarket;
use App\Services\SupermarketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class SupermarketController extends Controller
{
    private SupermarketService $supermarketService;

    public function __construct(SupermarketService $supermarketService)
    {
        $this->supermarketService = $supermarketService;
    }

    public function create(SupermarketStoreRequest $request): JsonResponse
    {
        $supermarket = $this->supermarketService->store($request->validated());

        return Response::Json(new SupermarketResource($supermarket), 201);
    }

    public function list(): SupermarketCollection
    {
        return new SupermarketCollection($this->supermarketService->list());
    }

    public function view(Supermarket $supermarket): SupermarketResource
    {
        return new SupermarketResource($supermarket);
    }

    public function update(SupermarketUpdateRequest $request, Supermarket $supermarket): SupermarketResource
    {
        $this->supermarketService->update($request->validated(), $supermarket);

        return new SupermarketResource($supermarket);
    }

    public function delete(Supermarket $supermarket): SupermarketResource
    {
        $supermarket->delete();

        return new SupermarketResource($supermarket);
    }
}

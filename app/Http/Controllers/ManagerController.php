<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ManagerStoreRequest;
use App\Http\Requests\ManagerUpdateRequest;
use App\Http\Resources\ManagerCollection;
use App\Http\Resources\ManagerResource;
use App\Models\Manager;
use App\Services\ManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ManagerController extends Controller
{
    private ManagerService $managerService;

    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    public function create(ManagerStoreRequest $request): JsonResponse
    {
        $manager = $this->managerService->store($request->validated());

        return Response::Json(new ManagerResource($manager), 201);
    }

    public function list(): ManagerCollection
    {
        return new ManagerCollection($this->managerService->list());
    }

    public function view(Manager $manager): ManagerResource
    {
        return new ManagerResource($this->managerService->view($manager));
    }

    public function update(ManagerUpdateRequest $request, Manager $manager): ManagerResource
    {
        $this->managerService->update($request->validated(), $manager);

        return new ManagerResource($manager);
    }
}

<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ManagerService
{
    private Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function store(array $managerAttributes): Manager
    {
        $manager = $this->manager->newInstance();
        $manager->fill($managerAttributes)->save();

        return $manager;
    }

    public function view(Manager $manager): Builder|array|Collection|Model
    {
        return Manager::query()
            ->with('supermarket')
            ->findOrFail($manager->id);
    }

    public function list(): Collection
    {
        return Manager::with('supermarket')->get();
    }

    public function update(array $managerAttributes, Manager $manager): Manager
    {
        $manager->update($managerAttributes);

        return $manager;
    }
}

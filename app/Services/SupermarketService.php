<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Supermarket;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class SupermarketService
{
    private Supermarket $supermarket;

    public function __construct(Supermarket $supermarket)
    {
        $this->supermarket = $supermarket;
    }

    public function store(array $supermarketAttributes): Supermarket
    {
        $supermarket = $this->supermarket->newInstance();
        $supermarket->fill($supermarketAttributes)->save();

        return $supermarket;
    }

    public function view(Supermarket $supermarket): Supermarket
    {
        return $supermarket;

    }

    public function list(): Collection|array
    {
        return QueryBuilder::for(Supermarket::class)
            ->allowedFilters([
                'name',
                'location',
            ])
            ->defaultSort('name')
            ->get();
    }

    public function update(array $supermarketAttributes, Supermarket $supermarket): Supermarket
    {
        $supermarket->update($supermarketAttributes);

        return $supermarket;
    }
}

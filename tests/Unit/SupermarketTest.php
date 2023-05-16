<?php

use App\Models\Supermarket;
use App\Services\SupermarketService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('can store a new supermarket', function () {
    $supermarketData = [
        'name' => 'Super Market',
        'location' => 'Test Location Name Kenya',
    ];

    $service = app(SupermarketService::class);
    $supermarket = $service->store($supermarketData);

    expect($supermarket->name)->toBe($supermarketData['name']);
    expect($supermarket->location)->toBe($supermarketData['location']);
});

it('can view a supermarket', function () {
    $supermarket = Supermarket::factory()->create();
    $service = app(SupermarketService::class);
    $supermarketData = $service->view($supermarket);
    expect($supermarket)->toHaveKeys(['id', 'name', 'location', 'created_at', 'updated_at']);
    expect($supermarket)
        ->name->toBe($supermarketData['name'])
        ->location->toBe($supermarketData['location']);

});

it('can list supermarkets', function () {
    Supermarket::factory()->count(3)->create();
    $service = app(SupermarketService::class);
    $supermarkets = $service->list();
    expect($supermarkets)->toHaveCount(3);
});

it('can update a supermarket', function () {
    $supermarket = Supermarket::factory()->create();
    $updatedData = [
        'name' => 'Super Market',
        'location' => 'Test Location Name Kenya',
    ];
    $service = app(SupermarketService::class);
    $updatedSupermarket = $service->update($updatedData, $supermarket);
    expect($updatedSupermarket->name)->toBe($updatedData['name']);
    expect($updatedSupermarket->location)->toBe($updatedData['location']);
});

it('can list supermarkets sorted by name alphabetically', function () {
    Supermarket::factory()->create(['name' => 'Z Supermarket']);
    Supermarket::factory()->create(['name' => 'A Supermarket']);
    Supermarket::factory()->create(['name' => 'M Supermarket']);

    $service = app(SupermarketService::class);
    $response = $service->list();

    $supermarkets = collect($response);

    expect($supermarkets)->toHaveCount(3);
    expect($supermarkets[0]['name'])->toBe('A Supermarket');
    expect($supermarkets[1]['name'])->toBe('M Supermarket');
    expect($supermarkets[2]['name'])->toBe('Z Supermarket');
});

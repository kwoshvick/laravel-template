<?php

declare(strict_types=1);

use App\Models\Manager;
use App\Models\Supermarket;
use App\Services\ManagerService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('can store a new manager', function () {
    $managerData = [
        'name' => 'Super Market',
        'email' => 'test@gmail.com',
        'phone' => '0700102030',
        'supermarket_id' => Supermarket::factory()->create()->id,
    ];
    $service = app(ManagerService::class);
    $managerData = $service->store($managerData);
    expect($managerData)
        ->name->toBe($managerData['name'])
        ->email->toBe($managerData['email'])
        ->phone->toBe($managerData['phone'])
        ->supermarket->id->toBe($managerData['supermarket_id']);
});

it('can view a manager', function () {
    Supermarket::factory()->create();
    $manager = Manager::factory()->create();
    $service = app(ManagerService::class);
    $managerData = $service->view($manager);
    expect($manager)->toHaveKeys(['id', 'name', 'email', 'phone', 'created_at', 'updated_at']);
    expect($manager)
        ->name->toBe($managerData['name'])
        ->email->toBe($managerData['email'])
        ->phone->toBe($managerData['phone'])
        ->supermarket->id->toBe($managerData['supermarket_id']);

});

it('can list managers', function () {
    Supermarket::factory()->create();
    Manager::factory()->count(3)->create();
    $service = app(ManagerService::class);
    $managers = $service->list();
    expect($managers)->toHaveCount(3);
});

it('can update a manager', function () {
    Supermarket::factory()->create();
    $manager = Manager::factory()->create();
    $updatedData = [
        'name' => 'Super Market',
        'email' => 'test@gmail.com',
        'phone' => '0700102030',
    ];
    $service = app(ManagerService::class);
    $updatedManager = $service->update($updatedData, $manager);
    expect($updatedManager)
        ->name->toBe($updatedData['name'])
        ->email->toBe($updatedData['email'])
        ->phone->toBe($updatedData['phone']);
});

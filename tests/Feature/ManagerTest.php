<?php

declare(strict_types=1);

use App\Models\Manager;
use App\Models\Supermarket;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('does not create a manager when fields are empty', function () {
    $managerResponse = $this->postJson('/api/v1/manager/create', []);
    $managerResponse->assertStatus(422);
    $managerContent = json_decode($managerResponse->content(), true);
    expect($managerContent['errors'])->toBeArray();
    $this->assertCount(4, $managerContent['errors']);
    expect($managerContent['errors'])->toHaveKeys(['name', 'phone', 'email', 'supermarket_id']);
});

it('creates a manager successfully', function () {
    $managerResponse = $this->postJson('/api/v1/manager/create', [
        'name' => 'Super Market',
        'email' => 'test@gmail.com',
        'phone' => '0700102030',
        'supermarket_id' => Supermarket::factory()->create()->id,
    ]);
    $managerResponse->assertStatus(201);
});

it('list the correct count of managers created', function () {
    Supermarket::factory()->create();
    Manager::factory()->count(20)->create();
    $managerResponse = $this->getJson('/api/v1/manager/list');
    $managerResponse->assertStatus(200);
    $managerContent = json_decode($managerResponse->content(), true);
    expect($managerContent)->toHaveKey('managers');
    $this->assertCount(20, $managerContent['managers']);
});

it('does not view a manager id doesnt exists', function () {
    Supermarket::factory()->create();
    Manager::factory()->create();
    $managerResponse = $this->getJson('/api/v1/manager/12345sdf/view');
    $managerResponse->assertStatus(404);
});

it('returns the correct details of a manager', function () {
    Supermarket::factory()->create();
    $manager = Manager::factory()->create();
    $managerResponse = $this->getJson('/api/v1/manager/'.$manager->id.'/view');
    $managerResponse->assertStatus(200);
    $managerContent = json_decode($managerResponse->content(), true);
    expect($managerContent)->toHaveKey('manager');
    expect($managerContent['manager'])->toHaveKeys(['name', 'phone', 'email', 'supermarket', 'created_at', 'updated_at']);
    expect($managerContent['manager'])
        ->name->toBe($manager->name)
        ->phone->toBe($manager->phone)
        ->email->toBe($manager->email)
        ->supermarket->id->toBe($manager->supermarket_id);
});

it('does not update a manager id doesnt exists', function () {
    $managerResponse = $this->putJson('/api/v1/manager/hygbu12345sdf/update', []);
    $managerResponse->assertStatus(404);
});

it('does not update a manager when fields are empty', function () {
    Supermarket::factory()->create();
    $manager = Manager::factory()->create();
    $managerResponse = $this->putJson('/api/v1/manager/'.$manager->id.'/update', [
        'name' => ' ',
        'email' => ' ',
        'phone' => '',
        'supermarket_id' => ' ',
    ]);
    $managerResponse->assertStatus(422);
    $managerContent = json_decode($managerResponse->content(), true);
    expect($managerContent['errors'])->toBeArray();
    $this->assertCount(4, $managerContent['errors']);
    expect($managerContent['errors'])->toHaveKeys(['name', 'phone', 'email', 'supermarket_id']);
});

it('updates a manager successfully ', function () {
    Supermarket::factory()->create();
    $manager = Manager::factory()->create();
    $managerResponse = $this->putJson('/api/v1/manager/'.$manager->id.'/update', [
        'name' => 'name 1',
        'phone' => '0712458596',
    ]);
    $managerResponse->assertStatus(200);
    $managerContent = json_decode($managerResponse->content(), true);
    expect($managerContent['manager'])
        ->name->toBe('name 1')
        ->phone->toBe('0712458596');
});

<?php

declare(strict_types=1);

use App\Models\Supermarket;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('does not create a supermarket when fields are empty', function () {
    $supermarketResponse = $this->postJson('/api/v1/supermarket/create', []);
    $supermarketResponse->assertStatus(422);
    $supermarketContent = json_decode($supermarketResponse->content(), true);
    expect($supermarketContent['errors'])->toBeArray();
    $this->assertCount(2, $supermarketContent['errors']);
    expect($supermarketContent['errors'])->toHaveKeys(['name', 'location']);
});

it('creates a supermarket successfully', function () {
    $supermarketResponse = $this->postJson('/api/v1/supermarket/create', [
        'name' => 'supermarket name',
        'location' => 'location name',
    ]);
    $supermarketResponse->assertStatus(201);
});

it('list the correct count of supermarket created', function () {
    Supermarket::factory()->count(20)->create();
    $supermarketResponse = $this->getJson('/api/v1/supermarket/list');
    $supermarketResponse->assertStatus(200);
    $supermarketContent = json_decode($supermarketResponse->content(), true);
    expect($supermarketContent)->toHaveKey('supermarkets');
    $this->assertCount(20, $supermarketContent['supermarkets']);
});

it('does not view a supermarket id doesnt exists', function () {
    Supermarket::factory()->create();
    $supermarketResponse = $this->getJson('/api/v1/supermarket/12345sdf/view');
    $supermarketResponse->assertStatus(404);
});

it('returns the correct details of a supermarket', function () {
    $supermarket = Supermarket::factory()->create();
    $supermarketResponse = $this->getJson('/api/v1/supermarket/'.$supermarket->id.'/view');
    $supermarketResponse->assertStatus(200);
    $supermarketContent = json_decode($supermarketResponse->content(), true);
    expect($supermarketContent)->toHaveKey('supermarket');
    expect($supermarketContent['supermarket'])->toHaveKeys(['id', 'name', 'location', 'created_at', 'updated_at']);
    expect($supermarketContent['supermarket'])
        ->name->toBe($supermarket->name)
        ->location->toBe($supermarket->location);
});

it('does not update a supermarket id doesnt exists', function () {
    Supermarket::factory()->create();
    $supermarketResponse = $this->putJson('/api/v1/supermarket/hygbu12345sdf/update', []);
    $supermarketResponse->assertStatus(404);
});

it('does not update a supermarket when fields are empty', function () {
    $supermarket = Supermarket::factory()->create();
    $supermarketResponse = $this->putJson('/api/v1/supermarket/'.$supermarket->id.'/update', [
        'name' => '',
        'location' => '',
    ]);
    $supermarketResponse->assertStatus(422);
    $supermarketContent = json_decode($supermarketResponse->content(), true);
    expect($supermarketContent['errors'])->toBeArray();
    $this->assertCount(2, $supermarketContent['errors']);
    expect($supermarketContent['errors'])->toHaveKeys(['name', 'location']);
});

it('updates a supermarket successfully ', function () {
    $supermarket = Supermarket::factory()->create();
    $supermarketResponse = $this->putJson('/api/v1/supermarket/'.$supermarket->id.'/update', [
        'name' => 'name 1',
        'location' => 'location 1',
    ]);
    $supermarketResponse->assertStatus(200);
    $supermarketContent = json_decode($supermarketResponse->content(), true);
    expect($supermarketContent['supermarket'])
        ->name->toBe('name 1')
        ->location->toBe('location 1');
});

it('deletes a supermarket from cart', function () {
    Supermarket::factory(3)->create();
    $supermarketResponse = $this->deleteJson('/api/v1/supermarket/'.Supermarket::all()->random()->id.'/delete');
    $supermarketResponse->assertStatus(200);
    $supermarketResponse2 = $this->getJson('/api/v1/supermarket/list');
    $supermarketResponse2->assertStatus(200);
    $supermarketContent = json_decode($supermarketResponse2->content(), true);
    expect($supermarketContent['supermarkets'])->toBeArray();
    $this->assertCount(2, $supermarketContent['supermarkets']);
});

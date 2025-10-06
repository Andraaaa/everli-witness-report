<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('throttles /api/reports after 5 requests per minute', function () {
    Config::set('cache.default', 'array');

    Http::fake(['*' => Http::response(['items' => []], 200)]);
    Storage::fake('local');

    $this->postJson('/api/reports', ['query' => 'AA', 'phone' => '+12025550001'])
        ->assertCreated();

    $this->postJson('/api/reports', ['query' => 'AA', 'phone' => '+12025550002'])
        ->assertCreated();

    $this->postJson('/api/reports', ['query' => 'AA', 'phone' => '+12025550002'])
        ->assertCreated();

    $this->postJson('/api/reports', ['query' => 'AA', 'phone' => '+12025550002'])
        ->assertCreated();

    $this->postJson('/api/reports', ['query' => 'AA', 'phone' => '+12025550002'])
        ->assertCreated();

    $this->postJson('/api/reports', ['query' => 'AA', 'phone' => '+12025550003'])
        ->assertStatus(429);
});

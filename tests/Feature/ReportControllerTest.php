<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\Http;

it('creates report and appends audit asynchronously', function () {
    Http::fake([
        'api.fbi.gov/*' => Http::response(['items'=>[['uid'=>'u1','title'=>'JOHN DOE','url'=>'https://...']]], 200),
        'ipapi.co/*'    => Http::response(['country'=>'US'], 200),
    ]);

    $response = $this->postJson('/api/reports', ['query'=>'John','phone'=>'+1 202 555 0101']);

    $response->assertCreated();
});

it('falls back to IP country when phone has no region', function () {
    Http::fake([
        'api.fbi.gov/*' => Http::response(['items'=>[]], 200),
        'ipapi.co/*'    => Http::response(['country'=>'DE'], 200),
    ]);

    $res = $this->postJson('/api/reports', [
        'query'=>'Unrelated',
        'phone'=>'12345'
    ], ['X-Forwarded-For' => '1.2.3.4']);

    $res->assertCreated()
        ->assertJsonPath('client_country', 'DE');
});


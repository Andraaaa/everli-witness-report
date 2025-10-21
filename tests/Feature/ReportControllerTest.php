<?php

namespace Tests\Feature;

use App\Enums\ReportValidity;
use App\Events\WitnessReportCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

it('creates report, dispatches event and listener writes file', function () {
    Event::spy();
    Storage::fake('local');

    Http::fake([
        'api.fbi.gov/*' => Http::response([
            'items' => [[
                'uid' => 'u1',
                'title' => 'JOHN DOE',
                'url' => 'https://...',
            ]],
        ], 200),
        'ipapi.co/*' => Http::response(['country' => 'US'], 200),
    ]);

    $response = $this->postJson('/api/reports', [
        'query' => 'John',
        'phone' => '+1 202 555 0101',
    ])->assertCreated()
        ->assertJsonPath('validity', ReportValidity::VALID->value);

    $id = $response->json('id');
    assertDatabaseHas('witness_reports', ['id' => $id]);

    Event::assertDispatched(WitnessReportCreated::class, fn ($event) => $event->report->id === $id
    );

    $path = "reports/{$id}.json";
    Storage::disk('local')->assertExists($path);

    $json = Storage::disk('local')->get($path);
    $data = json_decode($json, true);

    expect($data)
        ->id->toBe($id)
        ->query->toBe('John')
        ->phone_e164->toBe('+12025550101')
        ->client_country->toBe('US')
        ->validity->toBe(ReportValidity::VALID->value);
});

it('falls back to IP country when phone has no region', function () {
    $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4']);

    Http::fake([
        'api.fbi.gov/*' => Http::response(['items' => []], 200),
        'ipapi.co/*' => Http::response(['country' => 'DE'], 200),
    ]);

    $response = $this->postJson('/api/reports', [
        'query' => 'Unrelated',
        'phone' => '12345',
    ])
        ->assertCreated()
        ->assertJsonPath('validity', ReportValidity::INVALID->value)
        ->assertJsonPath('client_country', 'DE');
});

it('validates payload', function () {
    $this->postJson('/api/reports', [])->assertStatus(422)
        ->assertJsonValidationErrors(['query', 'phone']);
});

it('marks report as INVALID when FBI has no matches', function () {
    Http::fake(['api.fbi.gov/*' => Http::response(['items' => []], 200)]);
    $this->postJson('/api/reports', ['query' => 'XX', 'phone' => '+1 202 555 0101'])
        ->assertCreated()->assertJsonPath('validity', ReportValidity::INVALID->value);
});

it('normalizes phone to E.164', function () {
    Http::fake(['api.fbi.gov/*' => Http::response(['items' => [['uid' => 'u1']]], 200)]);
    $this->postJson('/api/reports', ['query' => 'John', 'phone' => '+1 202 555 0101'])
        ->assertCreated()->assertJsonPath('phone_e164', '+12025550101');
});

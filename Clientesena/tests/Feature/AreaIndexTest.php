<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AreaIndexTest extends TestCase
{
    public function test_areas_page_shows_an_error_when_api_requires_authentication(): void
    {
        config(['session.driver' => 'array']);
        Http::fake([
            '*' => Http::response(['message' => 'Unauthenticated.'], 401),
        ]);

        $response = $this->get('/areas');

        $response->assertOk();
        $response->assertSee('El servidor API requiere autenticación para consultar las áreas.');
    }
}

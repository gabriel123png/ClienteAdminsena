<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminSenaApiTest extends TestCase
{
    public function test_course_list_uses_api_prefix_and_displays_unwrapped_api_data(): void
    {
        config([
            'services.adminsena.url' => 'http://api.adminsena.test/api;',
        ]);

        Http::fake([
            'api.adminsena.test/api/courses' => Http::response([
                'success' => true,
                'data' => [[
                    'id' => 1,
                    'course_number' => 'Ficha de prueba',
                    'day' => 'Lunes',
                    'area' => ['nombre' => 'Desarrollo'],
                    'trainingCenter' => ['name' => 'Centro de prueba'],
                ]],
            ]),
        ]);

        $this->get('/courses')
            ->assertOk()
            ->assertSee('Ficha de prueba')
            ->assertSee('Desarrollo')
            ->assertSee('Centro de prueba');

        Http::assertSent(fn ($request) => $request->url() === 'http://api.adminsena.test/api/courses');
    }
}

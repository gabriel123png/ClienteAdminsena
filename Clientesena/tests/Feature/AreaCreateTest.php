<?php

namespace Tests\Feature;

use Tests\TestCase;

class AreaCreateTest extends TestCase
{
    public function test_create_area_page_displays_the_form(): void
    {
        $response = $this->get('/areas/create');

        $response->assertOk();
        $response->assertSee('Registrar Área');
        $response->assertSee('name="nombre"', false);
    }
}

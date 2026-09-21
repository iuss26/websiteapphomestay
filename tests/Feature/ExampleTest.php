<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test health check endpoint - always returns 200 without DB or session.
     */
    public function test_application_health_check_returns_ok(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }
}

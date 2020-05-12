<?php

namespace Tests\Feature;

use Tests\TestCase;

class PingTest extends TestCase
{
    /**
     * Test the ping response.
     *
     * @return void
     */
    public function testApiPostJson()
    {
        $response = $this->postJson('/api/v1/ping');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $response->assertSeeText('pong');
    }

    /**
     * Test the ping response.
     *
     * @return void
     */
    public function testApiPost()
    {
        $response = $this->post('/api/v1/ping');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertSeeText('pong');
    }

    /**
     * Test the ping response.
     *
     * @return void
     */
    public function testWebPostJson()
    {
        $response = $this->postJson('/ping');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $response->assertSeeText('pong');
    }

    /**
     * Test the ping response.
     *
     * @return void
     */
    public function testWebPost()
    {
        $response = $this->post('/ping');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertSeeText('pong');
    }

}

<?php

namespace Tests\Unit;

use Tests\TestCase;

class PingTest extends TestCase
{
    /**
     * A basic unit test example.
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

    public function testApiPost()
    {
        $response = $this->post('/api/v1/ping');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertSeeText('pong');
    }

    public function testWebPostJson()
    {
        $response = $this->postJson('/ping');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $response->assertSeeText('pong');
    }

    public function testWebPost()
    {
        $response = $this->post('/ping');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertSeeText('pong');
    }

}

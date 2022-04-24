<?php

namespace Tests\Feature;

use Tests\TestCase;

class SubscriberTest extends TestCase
{
    public function test_get_all_subscriber()
    {
        $response = $this->json('GET', 'api/subscribers');

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(206);
    }

    public function test_find_subscriber()
    {
        $response = $this->json('GET', 'api/subscribers/5');

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    public function test_create_subscriber()
    {
        $response = $this->json('POST', 'api/subscribers', [
            'name' => 'Bruce Wayne',
            'email_address' => 'bruce@wayneenterprises.org',
            'state_id' => 1,
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'Bruce Wayne')
            ->assertJsonPath('data.state', 'active');
    }

    public function test_update_subscriber()
    {
        $response = $this->json('PUT', 'api/subscribers/5', [
            'name' => 'Clark Kent',
            'email_address' => 'clark@dailyplanet.org',
            'state_id' => 1,
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200)
        ->assertJsonPath('subscriber.name', 'Clark Kent')
        ->assertJsonPath('subscriber.state', 'active');
    }

    public function test_delete_subscriber()
    {
        $response = $this->json('DELETE', 'api/subscribers/9');

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('subscribers', ['id' => 9]);
    }

    public function test_search_subscriber()
    {
        $response = $this->json('GET', 'api/subscribers/search/state/active');

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}

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
        $response = $this->json('GET', 'api/subscribers/11');

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    public function test_create_subscriber()
    {
        $response = $this->json('POST', 'api/subscribers', [
            'name' => 'Bruce Wayne',
            'email_address' => 'bruce@wayneenterprises.org',
            'state' => 'active',
            'fields' => [
                'company' => [
                    'type' => 'string',
                    'value' => 'wayne Enterprises',
                ],
                'height' => [
                    'type' => 'number',
                    'value' => '6.2',
                ],
                'DOB' => [
                    'type' => 'date',
                    'value' => '12-02-1989',
                ],
                'single' => [
                    'type' => 'boolean',
                    'value' => 'true',
                ],
            ],
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(201)
            ->assertJsonPath('subscriber.name', 'Bruce Wayne')
            ->assertJsonPath('subscriber.fields.company', 'wayne Enterprises');
        $this->assertDatabaseHas('fields', ['title' => 'single'])
            ->assertDatabaseHas('fields', ['type' => 'boolean']);
    }

    public function test_update_subscriber()
    {
        $response = $this->json('PUT', 'api/subscribers/11', [
            'name' => 'Clark Kent',
            'email_address' => 'clark@dailyplanet.org',
            'state' => 'junk',
            'fields' => [
                'company' => [
                    'type' => 'string',
                    'value' => 'The Daily Planet',
                ],
                'height' => [
                    'type' => 'number',
                    'value' => '6.3',
                ],
                'color' => [
                    'type' => 'string',
                    'value' => 'Blue',
                ],
            ],
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200)
        ->assertJsonPath('subscriber.name', 'Clark Kent')
        ->assertJsonPath('subscriber.fields.color', 'Blue');
        $this->assertDatabaseHas('fields', ['title' => 'color'])
            ->assertDatabaseHas('fields', ['type' => 'string']);
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

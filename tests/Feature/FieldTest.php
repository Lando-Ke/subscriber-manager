<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FieldTest extends TestCase
{

    public function test_create_field()
    {
        $response = $this->json('POST', 'api/subscriber/1/fields', [
            'title' => 'DOB',
            'type' => 'date',
            'value' => '18-02-04',
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'DOB',
            ]);
        $this->assertDatabaseHas('fields', ['value' => '18-02-04']);
    }

    public function test_update_field()
    {
        $response = $this->json('PUT', 'api/subscriber/2/fields/4', [
            'title' => 'height',
            'type' => 'number',
            'value' => '6.2',
        ]);

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'height',
            ]);
        $this->assertDatabaseHas('fields', ['value' => '6.2']);
    }
}

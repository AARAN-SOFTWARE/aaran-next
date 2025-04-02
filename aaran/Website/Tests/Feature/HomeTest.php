<?php

namespace Aaran\Website\Tests\Feature;

use Aaran\Common\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    // Ensures a fresh DB for each test

    /**
     * Test that a City can be created successfully.
     */
    public function test_is_application_running()
    {
//        $this->withoutExceptionHandling();

        config(['app.running' => true]);

        $this->get('/ff')->assertStatus(200);
    }

    /**
     * Test that a city can be retrieved by its name.
     */
    public function test_can_retrieve_city_by_name()
    {
        City::create([
            'vname' => 'City 1',
            'active_id' => '1',
        ]);

        $obj = City::where('vname', 'City 1')->first();

        $this->assertNotNull($obj);
    }

    /**
     * Test that a city's domain can be updated.
     */
    public function test_can_update_city()
    {
        $city = City::factory()->create(['vname' => 'new city 1']);

        $city->update(['vname' => 'new city 2']);

        $this->assertDatabaseHas('cities', ['vname' => 'new city 2']);
    }

    /**
     * Test that a city can be deleted.
     */
    public function test_can_delete_city()
    {
        $city = City::factory()->create();

        $city->delete();

        $this->assertDatabaseMissing('cities', ['id' => $city->id]);
    }
}

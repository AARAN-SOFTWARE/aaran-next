<?php


namespace Aaran\Core\Sys\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AaranApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_is_running()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_aaran_service_provider_is_registered()
    {
        $this->assertTrue(app()->providerIsLoaded(\Aaran\AaranServiceProvider::class));
    }

    public function test_configuration_is_loaded()
    {
        $this->assertNotEmpty(config('app.name'));
        $this->assertNotEmpty(config('database.default'));
    }

    public function test_application_key_is_set()
    {
        $this->assertNotEmpty(config('app.key'));
    }

    public function test_database_connection_is_working()
    {
        $this->assertTrue(
            Artisan::call('migrate:status', ['--database' => config('database.default')]) === 0
        );
    }
}

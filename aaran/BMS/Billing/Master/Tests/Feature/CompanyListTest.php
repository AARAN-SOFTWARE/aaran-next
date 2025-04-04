<?php

namespace Aaran\BMS\Billing\Master\Tests\Feature;

use Aaran\BMS\Billing\Common\Models\City;
use Aaran\BMS\Billing\Common\Models\Country;
use Aaran\BMS\Billing\Common\Models\Pincode;
use Aaran\BMS\Billing\Common\Models\State;
use Aaran\BMS\Billing\Master\Livewire\Class\CompanyList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CompanyListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

// Seed necessary location data
        $this->city = City::factory()->create();
        $this->state = State::factory()->create();
        $this->pincode = Pincode::factory()->create();
        $this->country = Country::factory()->create();
    }

    public function test_company_can_be_created()
    {
        Livewire::test(CompanyList::class)
            ->set('name', 'New Company')
            ->set('msme_type', 'MICRO')
            ->set('city_id', $this->city->id)
            ->set('state_id', $this->state->id)
            ->set('pincode_id', $this->pincode->id)
            ->set('country_id', $this->country->id)
            ->call('save')
            ->assertSessionHas('success', 'Company details saved!');

        $this->assertDatabaseHas('companies', [
            'name' => 'New Company',
            'msme_type' => 'MICRO',
            'city_id' => $this->city->id,
            'state_id' => $this->state->id,
            'pincode_id' => $this->pincode->id,
            'country_id' => $this->country->id,
        ]);
    }

    public function test_company_can_be_updated()
    {
        $company = Company::factory()->create([
            'name' => 'Old Company',
            'msme_type' => 'NONE',
        ]);

        Livewire::test(CompanyComponent::class, ['company' => $company])
            ->set('name', 'Updated Company')
            ->set('msme_type', 'SMALL')
            ->call('save')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'Updated Company',
            'msme_type' => 'SMALL',
        ]);
    }

    public function test_validation_errors_on_missing_required_fields()
    {
        Livewire::test(CompanyComponent::class)
            ->set('name', '')
            ->set('msme_type', 'INVALID') // Not in allowed list
            ->call('save')
            ->assertHasErrors([
                'name' => 'required',
                'msme_type' => 'in',
            ]);
    }

    public function test_dropdown_values_must_exist_in_database()
    {
        Livewire::test(CompanyComponent::class)
            ->set('name', 'Test Company')
            ->set('msme_type', 'MICRO')
            ->set('city_id', 999)
            ->set('state_id', 999)
            ->set('pincode_id', 999)
            ->set('country_id', 999)
            ->call('save')
            ->assertHasErrors([
                'city_id' => 'exists',
                'state_id' => 'exists',
                'pincode_id' => 'exists',
                'country_id' => 'exists',
            ]);
    }
}

<?php

namespace Aaran\Dashboard\Livewire\Class;

use Aaran\Assets\Enums\Active;
use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Master\Models\Company;

class SwitchDefaultCompany
{
    use ComponentStateTrait, TenantAwareTrait;

    public mixed $companies;


    public function getDefaultCompany()
    {
    }

    public function getAllCompanies(): void
    {
        $this->companies = Company::on($this->getTenantConnection())
            ->where('companies.active_id', Active::ACTIVE)->get();
    }

    public function render()
    {
        $this->getAllCompanies();
        $this->getDefaultCompany();
        return view('dashboard::switch-default-company');
    }

}

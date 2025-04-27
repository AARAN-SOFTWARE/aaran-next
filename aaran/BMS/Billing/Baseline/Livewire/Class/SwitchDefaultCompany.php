<?php

namespace Aaran\BMS\Billing\Baseline\Livewire\Class;

use Aaran\Assets\Enums\Active;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Baseline\Models\DefaultCompany;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SwitchDefaultCompany extends Component
{
    use TenantAwareTrait;

    public $companies;
    public $defaultCompany;
    public $showModal = false;

    public function showSwitchModal(): void
    {
        $this->showModal = true;
    }

    public function getDefaultCompany(): void
    {
        $this->defaultCompany = DB::connection($this->getTenantConnection())
            ->table('default_companies')
            ->join('companies', 'default_companies.company_id', '=', 'companies.id')
            ->where('default_companies.id', '1')->first();

        session()->put('company_id', $this->defaultCompany->company_id);
        session()->put('company_name', $this->defaultCompany->vname);
        session()->put('acyear_id', $this->defaultCompany->acyear_id);
    }

    public function getAllCompanies(): void
    {
        $this->companies = DB::connection($this->getTenantConnection())
            ->table('companies')
            ->where('companies.active_id', Active::ACTIVE->value)->get();
    }

    public function switchCompany($id): void
    {
        $obj = DefaultCompany::on($this->getTenantConnection())->find(1);
        $obj->company_id = $id;
        $obj->save();

        session()->put('company_id', $obj->company_id);
        session()->put('company_name', $this->defaultCompany->vname);
        session()->put('company_id', $obj->company_id);

        $this->showModal = false;
        $this->js('window.location.reload()');
    }

    public function changeAcyear(): void
    {
        $obj = DefaultCompany::on($this->getTenantConnection())->find(1);
        $obj->acyear_id = $this->defaultCompany->acyear_id;
        $obj->save();
        session()->put('acyear_id', $obj->acyear_id);
        $this->js('window.location.reload()');
    }


    public function render()
    {
        $this->getAllCompanies();
        $this->getDefaultCompany();
        return view('baseline::switch-default-company')->with([
            'list' => $this->companies,
            'defaultCompany' => $this->defaultCompany,
        ]);
    }

}

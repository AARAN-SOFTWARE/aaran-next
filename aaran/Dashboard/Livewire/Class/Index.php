<?php

namespace Aaran\Dashboard\Livewire\Class;

use Aaran\Assets\Traits\TenantAwareTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    use TenantAwareTrait;
    public $blogs = [];

    public function mount()
    {
        $this->getDefaultCompany();
    }

    public function getDefaultCompany(): void
    {
        $defaultCompany = DB::connection($this->getTenantConnection())
            ->table('default_companies')
            ->join('companies', 'default_companies.company_id', '=', 'companies.id')
            ->where('default_companies.id', '1')->first();

        session()->put('company_id', $defaultCompany->company_id);
        session()->put('company_name', $defaultCompany->vname);
        session()->put('acyear_id', $defaultCompany->acyear_id);
    }


    public function render()
    {
        return view('dashboard::index');
    }

}

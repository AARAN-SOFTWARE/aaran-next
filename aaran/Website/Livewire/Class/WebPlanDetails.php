<?php

namespace Aaran\Website\Livewire\Class;

use Aaran\Core\Tenant\Models\PlanFeature;
use Livewire\Component;

class WebPlanDetails extends Component
{
    public $plans = [];


    public function mount(): void
    {

        $this->plans = PlanFeature::select(

            'Plans.id as plan_id',
            'Plans.vname as plan_name',
            'Plans.price as plan_price',
            'Plans.billing_cycle as billing_cycle',
            'Plans.description as plan_description',

            'features.vname as feature_name',
            'features.description as feature_description',
        )
            ->leftJoin('plans', 'plans.id', '=', 'plan_features.plan_id')
            ->leftJoin('features', 'features.id', '=', 'plan_features.feature_id')
            ->get();

    }
    #[Layout('Ui::components.layouts.web')]
    public function render()
    {

        return view('website::web-plan-details');
    }
}

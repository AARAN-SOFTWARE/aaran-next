<?php

namespace Aaran\Core\Setup\Livewire\Class;

use Aaran\Core\Setup\Jobs\CreateTenantJob;
use Aaran\Core\Tenant\Models\Feature;
use Aaran\Core\Tenant\Models\Industry;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class TenantSetupWizard extends Component
{
    public $step = 1;
    public $b_name, $t_name, $email, $contact, $phone;
    public $db_name, $db_user = 'root', $db_pass = 'Computer.1';
    public $plan = 'free', $subscription_start, $subscription_end;
    public $storage_limit = 10, $user_limit = 5, $is_active = true;
    public $two_factor_enabled = false, $allow_sso = false;
    public $industry_id, $selected_features = [], $settings = [];
    public array $progress = [];

    protected $rules = [
        'b_name' => 'required|string|max:255',
        't_name' => 'required|string|max:255|unique:tenants,t_name',
        'email' => 'required|email|unique:tenants,email',
        'contact' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'db_name' => 'required|string|max:255|unique:tenants,db_name',
        'db_user' => 'required|string|max:255',
        'db_pass' => 'required|string',
        'plan' => 'required|string',
        'storage_limit' => 'required|numeric|min:1',
        'user_limit' => 'required|integer|min:1',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'allow_sso' => 'boolean',
        'industry_id' => 'required|exists:industries,id',
        'selected_features' => 'array',
    ];

    public function nextStep(): void
    {
        $this->validateStep();

        if ($this->step < 4) { // Ensure max step is 4
            $this->step++;
            Log::info("✅ Step changed to: {$this->step}");
            $this->dispatch('$refresh'); // Force UI update
        }
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
            Log::info("⬅️ Step changed to: {$this->step}");
            $this->dispatch('$refresh');
        }
    }

    public function validateStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'b_name' => 'required|string|max:255',
                't_name' => 'required|string|max:255|unique:tenants,t_name',
                'email' => 'required|email|unique:tenants,email',
                'contact' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:255',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'db_name' => 'required|string|max:255|unique:tenants,db_name',
                'db_user' => 'required|string|max:255',
                'db_pass' => 'required|string',
            ]);
        } elseif ($this->step === 3) {
            $this->validate([
                'industry_id' => 'required|exists:industries,id',
                'selected_features' => 'array',
            ]);
        } elseif ($this->step === 4) { // Ensure step 4 is validated
            $this->validate([
                'plan' => 'required|string',
                'storage_limit' => 'required|numeric|min:1',
                'user_limit' => 'required|integer|min:1',
                'is_active' => 'boolean',
                'two_factor_enabled' => 'boolean',
                'allow_sso' => 'boolean',
            ]);
        }
    }

    public function createTenant()
    {
        $this->validate();

        Log::info('🚀 Tenant setup started.', ['tenant_name' => $this->t_name]);

        DB::beginTransaction();
        try {
            $tenant = Tenant::create([
                'b_name' => $this->b_name,
                't_name' => $this->t_name,
                'email' => $this->email,
                'contact' => $this->contact,
                'phone' => $this->phone,
                'db_name' => $this->db_name,
                'db_host' => '127.0.0.1',
                'db_port' => '3306',
                'db_user' => $this->db_user,
                'db_pass' => $this->db_pass,
                'plan' => $this->plan,
                'subscription_start' => $this->subscription_start ?? now(),
                'subscription_end' => $this->subscription_end ?? null,
                'storage_limit' => $this->storage_limit,
                'user_limit' => $this->user_limit,
                'is_active' => $this->is_active,
                'two_factor_enabled' => $this->two_factor_enabled,
                'allow_sso' => $this->allow_sso,
                'industry_code' => Industry::find($this->industry_id)->code,
                'enabled_features' => json_encode($this->selected_features),
                'settings' => json_encode($this->settings),
            ]);

            Log::info('✅ Tenant created successfully.', ['tenant_id' => $tenant->id]);

            DB::commit();


            $this->runTenantMigrations($tenant);


            session()->flash('success', '🎉 Tenant created successfully!');
            $this->dispatch('tenant-created');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error during tenant setup.', ['error' => $e->getMessage()]);
            session()->flash('error', '❌ Error: ' . $e->getMessage());
        }
    }

    protected function runTenantMigrations($tenantId)
    {
//        $this->dispatch('tenant-setup-progress', message: 'starting Setup...');
        (new CreateTenantJob())->createTenant($tenantId);

    }

    public function setupss()
    {
        $tenant = Tenant::where('t_name', 'tenant_1')->first();

        $this->runTenantMigrations($tenant->id);
    }

    public $progressMessages = [];

    #[On('tenant-setup-progress')]
    public function handleProgress($message)
    {
        $this->progressMessages[] = $message;
    }
//    public function pollMigrationStatus()
//    {
//        $tenant = Tenant::where('t_name', $this->t_name)->first();
//        if ($tenant?->migration_status === 'success') {
//            $this->is_processing = false;
//            session()->flash('success', '🎉 Setup completed successfully!');
//            $this->dispatch('migration-success');
//        } elseif ($tenant?->migration_status === 'failed') {
//            $this->is_processing = false;
//            session()->flash('error', '❌ Migration failed. Please check logs or retry.');
//            $this->dispatch('migration-failed');
//        }
//    }


    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        Log::info("🔄 Rendering step: {$this->step}");

        return view('setup::tenant-setup-wizard', [
            'steps' => ['Tenant Details', 'Database Setup', 'Industry & Features', 'Subscription & Security'],
            'industries' => Industry::all(),
            'features' => Feature::all(),
            'currentStep' => $this->step // Pass step to the view
        ]);
    }
}

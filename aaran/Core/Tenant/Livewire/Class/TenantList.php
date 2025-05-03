<?php

namespace Aaran\Core\Tenant\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TenantList extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #[Validate]
    public string $b_name = '';
    public ?string $t_name = null;
    public ?string $email = null;
    public ?string $contact = null;
    public ?string $phone = null;
    public ?string $db_name = null;
    public ?string $db_host = null;
    public ?string $db_port = null;
    public ?string $db_user = 'root';
    public ?string $db_pass = 'Computer.1';
    public ?string $plan = null;
    public mixed $subscription_start = null;
    public mixed $subscription_end = null;
    public mixed $storage_limit = '50';
    public mixed $user_limit = '20';
    public ?string $industry_code = null;
    public mixed $settings = null;
    public mixed $enabled_features = null;
    public mixed $two_factor_enabled = null;
    public mixed $api_key = null;
    public mixed $whitelisted_ips = null;
    public mixed $allow_sso = null;
    public mixed $active_users = null;
    public mixed $requests_count = null;
    public mixed $disk_usage = null;
    public ?string $last_active_at = null;
    public ?string $migration_status = null;
    public bool $active_id = true;

    public function rules(): array
    {
        return [
            'b_name' => 'required',
            't_name' => 'required' . ($this->vid ? '' : "|unique:tenants,t_name"),
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'b_name.required' => ':attribute is missing.',

            't_name.required' => ':attribute is missing.',
            't_name.unique' => 'This :attribute is already created.',

            'db_name.required' => ':attribute is missing.',
            'db_user.required' => ':attribute is missing.',
            'db_pass.required' => ':attribute is missing.',

        ];
    }

    public function validationAttributes(): array
    {
        return [
            'b_name' => 'Business name',
            't_name' => 'Tenant name',
            'db_name' => 'Database name',
            'db_user' => 'Database user',
            'db_pass' => 'Database password',
        ];
    }

    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        Tenant::updateOrCreate(
            ['id' => $this->vid],
            [
                'b_name' => Str::ucfirst($this->b_name),
                't_name' => $this->t_name,
                'email' => $this->email,
                'contact' => $this->contact,
                'phone' => $this->phone,
                'db_name' => $this->db_name,
                'db_host' => $this->db_host ?: '127.0.0.1',
                'db_port' => $this->db_port ?: '3306',
                'db_user' => $this->db_user ?: 'root',
                'db_pass' => $this->db_pass ?: 'Computer.1',
                'plan' => $this->plan ?: 'free',
                'subscription_start' => $this->subscription_start ?: now(),
                'subscription_end' => $this->subscription_end ?: now()->addYear(),
                'storage_limit' => $this->storage_limit ?: '50',
                'user_limit' => $this->user_limit ?: '5',
                'active_id' => $this->active_id ?: true,
                'industry_code' => $this->industry_code,
                'settings' => $this->settings,
                'enabled_features' => $this->enabled_features,
                'two_factor_enabled' => $this->two_factor_enabled ?: false,
                'api_key' => $this->api_key ?: 'api_key_' . $this->t_name,
                'whitelisted_ips' => $this->whitelisted_ips ?: ['192.168.1.1'],
                'allow_sso' => $this->allow_sso ?: false,
                'active_users' => $this->active_users ?: 0,
                'requests_count' => $this->requests_count ?: 0,
                'disk_usage' => $this->disk_usage ?: 0,
                'last_active_at' => $this->last_active_at ?: now(),
                'migration_status' => $this->migration_status ?: 'pending',
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }

    public function clearFields(): void
    {
        $this->vid = null;
        $this->b_name = '';
        $this->t_name = '';
        $this->email = '';
        $this->contact = '';
        $this->phone = '';

        $this->db_name = '';
        $this->db_host = '127.0.0.1';
        $this->db_port = '3306';
        $this->db_user = 'root';
        $this->db_pass = 'Computer.1';

        $this->plan = 'free';
        $this->subscription_start = now();
        $this->subscription_end = now()->addYear();
        $this->storage_limit = '50';
        $this->user_limit = '5';

        $this->active_id = true;

        $this->industry_code = '100';
        $this->settings = [];

        $this->enabled_features = [];
        $this->two_factor_enabled = false;
        $this->api_key = '';
        $this->whitelisted_ips = '';
        $this->allow_sso = false;

        $this->active_users = '0';
        $this->requests_count = '0';
        $this->disk_usage = '0';
        $this->last_active_at = now();
        $this->migration_status = 'pending';
    }

    public function getObj(int $id): void
    {
        if ($obj = Tenant::find($id)) {
            $this->vid = $obj->id;
            $this->b_name = $obj->b_name;
            $this->t_name = $obj->t_name;
            $this->email = $obj->email;
            $this->contact = $obj->contact;
            $this->phone = $obj->phone;

            $this->db_name = $obj->db_name;
            $this->db_host = $obj->db_host;
            $this->db_port = $obj->db_port;
            $this->db_user = $obj->db_user;
            $this->db_pass = $obj->db_pass;

            $this->plan = $obj->plan;
            $this->subscription_start = $obj->subscription_start;
            $this->subscription_end = $obj->subscription_end;
            $this->storage_limit = $obj->storage_limit;
            $this->user_limit = $obj->user_limit;

            $this->active_id = $obj->active_id;

            $this->industry_code = $obj->industry_code;
            $this->settings = $obj->settings;

            $this->enabled_features = $obj->enabled_features;
            $this->two_factor_enabled = $obj->two_factor_enabled;
            $this->api_key = $obj->api_key;
            $this->whitelisted_ips = $obj->whitelisted_ips;
            $this->allow_sso = $obj->allow_sso;

            $this->active_users = $obj->active_users;
            $this->requests_count = $obj->requests_count;
            $this->disk_usage = $obj->disk_usage;
            $this->last_active_at = $obj->last_active_at;
            $this->migration_status = $obj->migration_status;
        }
    }

    public function getList()
    {
        return Tenant::when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = Tenant::find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }

    public function render()
    {
        return view('tenant::tenant-list', [
            'list' => $this->getList()
        ]);
    }
}

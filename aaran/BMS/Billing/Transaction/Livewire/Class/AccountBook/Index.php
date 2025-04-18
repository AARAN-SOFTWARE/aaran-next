<?php

namespace Aaran\BMS\Billing\Transaction\Livewire\Class\AccountBook;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Transaction\Models\AccountBook;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public string $transaction_type_id = '';
    public string $transaction_type_name = '';
    #[Validate]
    public string $vname = '';
    public string $account_no = '';
    public string $ifsc_code = '';
    public string $bank_id = '';
    public string $bank_name = '';
    public string $account_type_id = '';
    public string $account_type_name = '';
    public string $branch = '';
    public string $opening_balance = '';
    public string $opening_balance_date = '';
    public string $current_balance = '';
    public string $current_balance_date = '';
    public string $current_entry_id = '';
    public string $notes = '';

    public bool $active_id = true;

    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.cities,vname"),
        ];
    }

    public function messages(): array
    {
        return [
            'vname.required' => ':attribute is missing.',
            'vname.unique' => 'This :attribute is already created.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'vname' => 'Account Book Name',
        ];
    }

    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();


        if ($this->transaction_type_id == 1) {
            $this->account_no = '-';
            $this->ifsc_code = '-';
            $this->bank_id = '1';
            $this->account_type_id = '1';
            $this->branch = '-';
        }

        AccountBook::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'transaction_type_id' => $this->transaction_type_id,
                'vname' => Str::ucfirst($this->vname),
                'account_no' => $this->account_no,
                'ifsc_code' => $this->ifsc_code,
                'bank_id' => $this->bank_id,
                'account_type_id' => $this->account_type_id,
                'branch' => $this->branch,
                'opening_balance' => $this->opening_balance,
                'opening_balance_date' => $this->opening_balance_date,
                'current_balance' => $this->current_balance,
                'current_balance_date' => $this->current_balance_date,
                'current_entry_id' => $this->current_entry_id,
                'notes' => $this->notes,
                'company_id' => '1',
                'active_id' => $this->active_id
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }

    public function clearFields(): void
    {
        $this->vid = null;
        $this->transaction_type_id = '';
        $this->transaction_type_name = '';
        $this->vname = '';
        $this->account_no = '';
        $this->ifsc_code = '';
        $this->bank_id = '';
        $this->bank_name = '';
        $this->account_type_id = '';
        $this->account_type_name = '';
        $this->branch = '';
        $this->opening_balance = '';
        $this->opening_balance_date = '';
        $this->current_balance = '';
        $this->current_balance_date = '';
        $this->current_entry_id = '';
        $this->notes = '';
        $this->active_id = true;
        $this->searches = '';

        $this->dispatch('refresh-transaction-type-lookup', $this->transaction_type_name);
        $this->dispatch('refresh-bank-lookup', $this->bank_name);
        $this->dispatch('refresh-account-type-lookup', $this->account_type_name);
    }

    public function getObj(int $id): void
    {
        if ($obj = AccountBook::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->transaction_type_id = $obj->transaction_type_id;
            $this->transaction_type_name = $obj->transaction_type->vname;

            $this->vname = $obj->vname;
            $this->account_no = $obj->account_no;
            $this->ifsc_code = $obj->ifsc_code;

            $this->bank_id = $obj->bank_id;
            $this->bank_name = $obj->bank->vname;

            $this->account_type_id = $obj->account_type_id;
            $this->account_type_name = $obj->account_type->vname;

            $this->branch = $obj->branch;
            $this->opening_balance = $obj->opening_balance;
            $this->opening_balance_date = $obj->opening_balance_date;
            $this->current_balance = $obj->current_balance;
            $this->current_balance_date = $obj->current_balance_date;
            $this->current_entry_id = $obj->current_entry_id;
            $this->notes = $obj->notes;
            $this->active_id = $obj->active_id;

            $this->dispatch('refresh-transaction-type-lookup', $this->transaction_type_name);
            $this->dispatch('refresh-bank-lookup', $this->bank_name);
            $this->dispatch('refresh-account-type-lookup', $this->account_type_name);

        }
    }

    public function getList()
    {
        return AccountBook::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = AccountBook::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }

    #[On('refresh-transaction-type')]
    public function refreshTransactionType($id): void
    {
        $this->transaction_type_id = $id;
    }

    #[On('refresh-bank')]
    public function refreshBank($id): void
    {
        $this->bank_id = $id;
    }

    #[On('refresh-account-type')]
    public function refreshAccountType($id): void
    {
        $this->account_type_id = $id;
    }


    public function render()
    {
        return view('transaction::account-book.index', [
            'list' => $this->getList()
        ]);
    }
}

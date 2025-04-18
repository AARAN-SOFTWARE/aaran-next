<?php

namespace Aaran\BMS\Billing\Transaction\Livewire\Class\Transaction;

use Aaran\Assets\Enums\PaymentMethod;
use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Transaction\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public string $account_book_id = '';
    public string $transaction_mode = '';
    #[Validate]
    public string $contact_id = '';
    public string $contact_name = '';

    public string $vch_no = '';
    public string $vdate = '';
    public string $amount = '';
    public ?string $remarks;
    public ?string $payment_method;
    public string $chq_no = '';
    public string $chq_date = '';
    public string $instrument_bank_id = '';
    public string $deposit_on = '';
    public string $realised_on = '';

    public bool $active_id = true;

    public function rules(): array
    {
        return [
//            'transaction_mode' => 'required',
//            'payment_method' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
//            'transaction_mode.required' => ':attribute is missing.',
//            'payment_method.required' => ':attribute is missing.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
//            'transaction_mode' => 'Account Book Name',
//            'payment_method' => 'Account Book Name',
        ];
    }

    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();


        if ($this->payment_method == PaymentMethod::CASH) {
            $this->chq_no = '-';
            $this->chq_date = '-';
            $this->instrument_bank_id = '1';
            $this->deposit_on = '';
            $this->realised_on = '';
        }

        Transaction::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'acyear' => '1',
                'company_id' => '1',
                'account_book_id' => $this->account_book_id,
                'transaction_mode' => $this->transaction_mode,
                'contact_id' => $this->contact_id,
                'vch_no' => $this->vch_no,
                'vdate' => $this->vdate,
                'amount' => $this->amount,
                'remarks' => $this->remarks,
                'payment_method' => $this->payment_method,
                'chq_no' => $this->chq_no,
                'chq_date' => $this->chq_date,
                'instrument_bank_id' => $this->instrument_bank_id,
                'deposit_on' => $this->deposit_on,
                'realised_on' => $this->realised_on,
                'active_id' => $this->active_id
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }

    public function clearFields(): void
    {
        $this->vid = null;
        $this->account_book_id = '';
        $this->transaction_mode = '1';
        $this->contact_id = '';
        $this->vch_no = '';
        $this->vdate = '';
        $this->amount = '';
        $this->remarks = '';
        $this->payment_method = '';
        $this->chq_no = '';
        $this->chq_date = '';
        $this->instrument_bank_id = '';
        $this->deposit_on = '';
        $this->realised_on = '';
        $this->active_id = true;

    }

    public function getObj(int $id): void
    {
        if ($obj = Transaction::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->account_book_id = $obj->account_book_id;
            $this->transaction_mode = $obj->transaction_mode;

            $this->contact_id = $obj->contact_id;
            $this->vch_no = $obj->vch_no;
            $this->vdate = $obj->vdate;

            $this->amount = $obj->amount;
            $this->remarks = $obj->remarks;

            $this->payment_method = $obj->payment_method;
            $this->chq_no = $obj->chq_no;
            $this->chq_date = $obj->chq_date;
            $this->instrument_bank_id = $obj->instrument_bank_id;
            $this->deposit_on = $obj->deposit_on;
            $this->realised_on = $obj->realised_on;
            $this->active_id = $obj->active_id;
        }
    }

    public function getList()
    {
        return Transaction::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = Transaction::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }

    #[On('refresh-payment-method')]
    public function refreshBank($id): void
    {
        $this->payment_method = $id;
    }

    public function render()
    {
        return view('transaction::transaction.index', [
            'list' => $this->getList()
        ]);
    }
}

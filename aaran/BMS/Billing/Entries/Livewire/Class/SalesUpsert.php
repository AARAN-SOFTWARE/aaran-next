<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Livewire\Forms\SalesForm;
use Aaran\BMS\Billing\Entries\Livewire\Forms\SalesItemForm;
use Aaran\BMS\Billing\Entries\Models\Sale;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class SalesUpsert extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public SalesForm $form;
    public SalesItemForm $itemForm;

    public $billing_id;
    public $shipping_id;

    public ?float $grandTotalBeforeRound = null;


    #[On('refresh-contact')]
    public function refreshContact($id): void
    {
        $this->form->contact_id = $id;
    }

    #[On('refresh-order')]
    public function refreshOrder($id): void
    {
        $this->form->order_id = $id;
    }

    #[On('refresh-style')]
    public function refreshStyle($id): void
    {
        $this->form->style_id = $id;
    }

    #[On('refresh-billing')]
    public function refreshBilling($v): void
    {
        $contactAddress = ContactAddress::on($this->getTenantConnection())
            ->where('contact_id', $v)
            ->first();

        $this->billing_id = $contactAddress->id;
    }

    #[On('refresh-shipping')]
    public function refreshShipping($v): void
    {
        $contactAddress = ContactAddress::on($this->getTenantConnection())
            ->where('contact_id', $v)
            ->first();

        $this->shipping_id = $contactAddress->id;
    }

    #[On('refresh-billing-selected')]
    public function refreshBillingSelected($v): void
    {
        $this->billing_id = $v;
    }

    #[On('refresh-shipping-selected')]
    public function refreshShippingSelected($v): void
    {
        $this->shipping_id = $v;
    }

    #[On('refresh-product')]
    public function refreshProduct($v): void
    {
        $this->itemForm->product_id = $v['id'];
        $this->itemForm->product_name = $v['vname'];
        $this->itemForm->gst_percent = $v['gst_percent'];
    }

    #[On('refresh-colour')]
    public function refreshColour($v): void
    {
        $this->itemForm->colour_id = $v['id'];
        $this->itemForm->colour_name = $v['vname'];
    }

    #[On('refresh-size')]
    public function refreshSize($v): void
    {
        $this->itemForm->size_id = $v['id'];
        $this->itemForm->size_name = $v['vname'];
    }

    public function getSave()
    {
        $this->form->billing_id = $this->billing_id ?? '1';
        $this->form->shipping_id = $this->shipping_id ?? '1';

//        dd($this->form);
        dd($this->itemForm->itemList);

        $message = $this->form->createOrUpdate();
        if ($message === 'success') {
            $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->form->vid ? 'Updated' : 'Saved') . ' Successfully']);
            $this->form->setDefaultValues();
        } else {
            $this->dispatch('notify', ...['type' => 'error', 'content' => $message]);
        }
    }

    public function mount($id = null): void
    {
        if (!is_null($id)) {
            $obj = Sale::on($this->getTenantConnection())->find($id);

            if ($obj) {
                $this->form->loadValues($obj);
            } else {
                $this->form->setDefaultValues();
            }
        } else {
            $this->form->setDefaultValues();
        }
    }

    #region[add items]

    public function addItems(): void
    {
        $qty = (float)$this->itemForm->qty;
        $price = (float)$this->itemForm->price;
        $gstPercent = (float)$this->itemForm->gst_percent;

        if ($this->itemForm->itemIndex === '') {
            // Add new item
            if ($this->itemForm->product_name && $price && $qty) {
                $this->itemForm->itemList[] = $this->buildItemArray($qty, $price, $gstPercent);
            }
        } else {
            // Update existing item
            $index = $this->itemForm->itemIndex;
            $this->itemForm->itemList[$index] = $this->buildItemArray($qty, $price, $gstPercent);
        }

        $this->calculateTotal();
        $this->resetItems();
        $this->render();
    }

    protected function buildItemArray($qty, $price, $gstPercent): array
    {
        $taxable = $qty * $price;
        $gstAmount = $taxable * $gstPercent / 100;

        return [
            'po_no' => $this->itemForm->po_no,
            'dc_no' => $this->itemForm->dc_no,
            'no_of_roll' => $this->itemForm->no_of_roll,
            'product_name' => $this->itemForm->product_name,
            'product_id' => $this->itemForm->product_id,
            'colour_id' => $this->itemForm->colour_id,
            'colour_name' => $this->itemForm->colour_name,
            'size_id' => $this->itemForm->size_id,
            'size_name' => $this->itemForm->size_name,
            'qty' => $qty,
            'price' => $price,
            'gst_percent' => $gstPercent,
            'description' => $this->itemForm->description,
            'taxable' => $taxable,
            'gst_amount' => $gstAmount,
            'subtotal' => $taxable + $gstAmount,
        ];
    }

    public function resetItems(): void
    {
        $this->dispatch('refresh-product-lookup', null);
        $this->dispatch('refresh-colour-lookup', null);
        $this->dispatch('refresh-size-lookup', null);

        $fields = [
            'itemIndex', 'po_no', 'dc_no', 'no_of_roll', 'product_name', 'product_id', 'description',
            'colour_name', 'colour_id', 'size_name', 'size_id', 'qty', 'price', 'gst_percent',
        ];

        foreach ($fields as $field) {
            $this->itemForm->{$field} = '';
        }

        $this->calculateTotal();
    }

    public function changeItems($index): void
    {
        if (!isset($this->itemForm->itemList[$index])) return;

        $item = $this->itemForm->itemList[$index];

        $this->itemForm->itemIndex = $index;

        foreach ($item as $key => $value) {
            $this->itemForm->{$key} = $value;
        }

        $this->dispatch('refresh-product-lookup', ['vname' => $this->itemForm->product_name]);
        $this->dispatch('refresh-colour-lookup', ['vname' => $this->itemForm->colour_name]);
        $this->dispatch('refresh-size-lookup', ['vname' => $this->itemForm->size_name]);

        $this->calculateTotal();
    }

    public function deleteItem($index): void
    {
        if (!isset($this->itemForm->itemList[$index])) {
            throw new Exception("Item at index {$index} does not exist.");
        }

        unset($this->itemForm->itemList[$index]);
        $this->itemForm->itemList = array_values($this->itemForm->itemList);
        $this->calculateTotal();
    }

    public function removeItems($index): void
    {
        unset($this->itemForm->itemList[$index]);
        $this->itemForm->itemList = array_values($this->itemForm->itemList);
        $this->calculateTotal();
    }

    #endregion


    #region[Calculate total]

    public function calculateTotal(): void
    {
        if (!empty($this->itemForm->itemList)) {

            // Reset all totals
            $totalQty = 0;
            $totalTaxable = 0;
            $totalGst = 0;
            $grandTotalBeforeRound = 0;

            // Loop through item list and accumulate values
            foreach ($this->itemForm->itemList as $row) {
                $totalQty += round((float)$row['qty'], 3);
                $totalTaxable += round((float)$row['taxable'], 2);
                $totalGst += round((float)$row['gst_amount'], 2);
                $grandTotalBeforeRound += round((float)$row['subtotal'], 2);
            }

            // Assign accumulated values
            $this->form->total_qty = $totalQty;
            $this->form->total_taxable = $totalTaxable;
            $this->form->total_gst = $totalGst;
            $this->grandTotalBeforeRound = $grandTotalBeforeRound;

            // Grand total rounding
            $this->form->grand_total = round($grandTotalBeforeRound);
            $this->form->round_off = $this->form->grand_total - $grandTotalBeforeRound;

            // Round-off fix (adjust negative if needed)
            if ($this->form->round_off > 0) {
                $this->form->round_off = -1 * round(abs($this->form->round_off), 2);
            } else {
                $this->form->round_off = round($this->form->round_off, 2);
            }

            // Final grand total after adjustments
            $this->form->grand_total = round($this->form->grand_total + (float)($this->form->additional ?? 0), 2);
        }
    }

    #endregion


    public function render()
    {
        return view('entries::sales-upsert');
    }
}

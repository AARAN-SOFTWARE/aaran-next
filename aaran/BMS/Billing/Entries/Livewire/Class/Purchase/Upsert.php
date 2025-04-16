<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Class\Purchase;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\GstPercent;
use Aaran\BMS\Billing\Entries\Livewire\Forms\Purchase\MainForm;
use Aaran\BMS\Billing\Entries\Livewire\Forms\Purchase\ItemForm;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Aaran\BMS\Billing\Entries\Models\Purchase;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class Upsert extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public MainForm $purchase;
    public ItemForm $purchaseItems;

    public $billing_id;
    public $shipping_id;

    public ?float $grandTotalBeforeRound = null;


    #[On('refresh-contact')]
    public function refreshContact($id): void
    {
        $this->purchase->contact_id = $id;
    }

    #[On('refresh-order')]
    public function refreshOrder($id): void
    {
        $this->purchase->order_id = $id;
    }

    #[On('refresh-style')]
    public function refreshStyle($id): void
    {
        $this->purchase->style_id = $id;
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

    #[On('refresh-transport')]
    public function refreshTransport($v): void
    {
        $this->purchase->trans_id = $v;
    }

    #[On('refresh-product')]
    public function refreshProduct($v): void
    {
        $this->purchaseItems->product_id = $v['id'];
        $this->purchaseItems->product_name = $v['vname'];
        $this->purchaseItems->gst_percent = $v['gst_percent'];
    }

    #[On('refresh-product-from-model')]
    public function refreshProductModal($v): void
    {
        $this->purchaseItems->product_id = $v['id'];
        $this->purchaseItems->product_name = $v['vname'];
        $this->purchaseItems->gst_percent = !empty($v['gst_percent_id'])
            ? GstPercent::on($this->getTenantConnection())->findOrFail($v['gst_percent_id'])->vname
            : '0';

    }

    #[On('refresh-colour')]
    public function refreshColour($v): void
    {
        $this->purchaseItems->colour_id = $v['id'];
        $this->purchaseItems->colour_name = $v['vname'];
    }

    #[On('refresh-size')]
    public function refreshSize($v): void
    {
        $this->purchaseItems->size_id = $v['id'];
        $this->purchaseItems->size_name = $v['vname'];
    }

    public function getSave()
    {
        $this->purchase->billing_id = $this->billing_id ?? '1';
        $this->purchase->shipping_id = $this->shipping_id ?? '1';

        $message = $this->purchase->createOrUpdate();
        if ($message === 'success') {
            $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->purchase->vid ? 'Updated' : 'Saved') . ' Successfully']);
            $this->purchase->setDefaultValues();

            $this->redirect(route('purchases'));

        } else {
            $this->dispatch('notify', ...['type' => 'error', 'content' => $message]);
        }
    }

    public function clearFields(): void
    {
        $this->purchase->setDefaultValues();
    }

    public function mount($id = null): void
    {
        if (!is_null($id)) {
            $obj = Purchase::on($this->getTenantConnection())->find($id);

            if ($obj) {
                $this->purchase->loadValues($obj);
            } else {
                $this->purchase->setDefaultValues();
            }
        } else {
            $this->purchase->setDefaultValues();
        }
    }

    #region[add items]

    public function addItems(): void
    {
        $qty = (float)$this->purchaseItems->qty;
        $price = (float)$this->purchaseItems->price;
        $gstPercent = (float)$this->purchaseItems->gst_percent;

        if ($this->purchaseItems->itemIndex === '') {
            // Add new item
            if ($this->purchaseItems->product_name && $price && $qty) {
                $this->purchase->itemList[] = $this->buildItemArray($qty, $price, $gstPercent);
            }
        } else {
            // Update existing item
            $index = $this->purchaseItems->itemIndex;
            $this->purchase->itemList[$index] = $this->buildItemArray($qty, $price, $gstPercent);
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
            'po_no' => $this->purchaseItems->po_no,
            'dc_no' => $this->purchaseItems->dc_no,
            'no_of_roll' => $this->purchaseItems->no_of_roll,
            'product_name' => $this->purchaseItems->product_name,
            'product_id' => $this->purchaseItems->product_id,
            'colour_id' => $this->purchaseItems->colour_id,
            'colour_name' => $this->purchaseItems->colour_name,
            'size_id' => $this->purchaseItems->size_id,
            'size_name' => $this->purchaseItems->size_name,
            'qty' => $qty,
            'price' => $price,
            'gst_percent' => $gstPercent,
            'description' => $this->purchaseItems->description,
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
            $this->purchaseItems->{$field} = '';
        }

        $this->calculateTotal();
    }

    public function changeItems($index): void
    {
        if (!isset($this->purchase->itemList[$index])) return;

        $item = $this->purchase->itemList[$index];

        $this->purchaseItems->itemIndex = $index;

        foreach ($item as $key => $value) {
            $this->purchaseItems->{$key} = $value;
        }

        $this->dispatch('refresh-product-lookup', ['vname' => $this->purchaseItems->product_name]);
        $this->dispatch('refresh-colour-lookup', ['vname' => $this->purchaseItems->colour_name]);
        $this->dispatch('refresh-size-lookup', ['vname' => $this->purchaseItems->size_name]);

        $this->calculateTotal();
    }

    public function deleteItem($index): void
    {
        if (!isset($this->purchase->itemList[$index])) {
            throw new Exception("Item at index {$index} does not exist.");
        }

        unset($this->purchase->itemList[$index]);
        $this->purchase->itemList = array_values($this->purchase->itemList);
        $this->calculateTotal();
    }

    public function removeItems($index): void
    {
        unset($this->purchase->itemList[$index]);
        $this->purchase->itemList = array_values($this->purchase->itemList);
        $this->calculateTotal();
    }

    #endregion


    #region[Calculate total]

    public function calculateTotal(): void
    {
        if (!empty($this->purchase->itemList)) {

            // Reset all totals
            $totalQty = 0;
            $totalTaxable = 0;
            $totalGst = 0;
            $grandTotalBeforeRound = 0;

            // Loop through item list and accumulate values
            foreach ($this->purchase->itemList as $row) {
                $totalQty += round((float)$row['qty'], 3);
                $totalTaxable += round((float)$row['taxable'], 2);
                $totalGst += round((float)$row['gst_amount'], 2);
                $grandTotalBeforeRound += round((float)$row['subtotal'], 2);
            }

            // Assign accumulated values
            $this->purchase->total_qty = $totalQty;
            $this->purchase->total_taxable = $totalTaxable;
            $this->purchase->total_gst = $totalGst;
            $this->grandTotalBeforeRound = $grandTotalBeforeRound;

            // Grand total rounding
            $this->purchase->grand_total = round($grandTotalBeforeRound);
            $this->purchase->round_off = $this->purchase->grand_total - $grandTotalBeforeRound;

            // Round-off fix (adjust negative if needed)
            if ($this->purchase->round_off > 0) {
                $this->purchase->round_off = -1 * round(abs($this->purchase->round_off), 2);
            } else {
                $this->purchase->round_off = round($this->purchase->round_off, 2);
            }

            // Final grand total after adjustments
            $this->purchase->grand_total = round($this->purchase->grand_total + (float)($this->purchase->additional ?? 0), 2);
        }
    }

    #endregion

    public function getRoute()
    {
        $this->redirect(route('purchases'));
    }

    public function render()
    {
        return view('entries::purchase.upsert');
    }
}

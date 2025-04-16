<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Class\Sale;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\GstPercent;
use Aaran\BMS\Billing\Entries\Livewire\Forms\Sale\MainForm;
use Aaran\BMS\Billing\Entries\Livewire\Forms\Sale\ItemForm;
use Aaran\BMS\Billing\Entries\Models\Sale;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class Upsert extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public MainForm $sale;
    public ItemForm $saleItems;

    public $billing_id;
    public $shipping_id;

    public ?float $grandTotalBeforeRound = null;


    #[On('refresh-contact')]
    public function refreshContact($id): void
    {
        $this->sale->contact_id = $id;
    }

    #[On('refresh-order')]
    public function refreshOrder($id): void
    {
        $this->sale->order_id = $id;
    }

    #[On('refresh-style')]
    public function refreshStyle($id): void
    {
        $this->sale->style_id = $id;
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
        $this->sale->trans_id = $v;
    }

    #[On('refresh-product')]
    public function refreshProduct($v): void
    {
        $this->saleItems->product_id = $v['id'];
        $this->saleItems->product_name = $v['vname'];
        $this->saleItems->gst_percent = $v['gst_percent'];
    }

    #[On('refresh-product-from-model')]
    public function refreshProductModal($v): void
    {
        $this->saleItems->product_id = $v['id'];
        $this->saleItems->product_name = $v['vname'];
        $this->saleItems->gst_percent = !empty($v['gst_percent_id'])
            ? GstPercent::on($this->getTenantConnection())->findOrFail($v['gst_percent_id'])->vname
            : '0';

    }

    #[On('refresh-colour')]
    public function refreshColour($v): void
    {
        $this->saleItems->colour_id = $v['id'];
        $this->saleItems->colour_name = $v['vname'];
    }

    #[On('refresh-size')]
    public function refreshSize($v): void
    {
        $this->saleItems->size_id = $v['id'];
        $this->saleItems->size_name = $v['vname'];
    }

    public function getSave()
    {
        $this->sale->billing_id = $this->billing_id ?? '1';
        $this->sale->shipping_id = $this->shipping_id ?? '1';

        $message = $this->sale->createOrUpdate();
        if ($message === 'success') {
            $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->sale->vid ? 'Updated' : 'Saved') . ' Successfully']);
            $this->sale->setDefaultValues();

            $this->redirect(route('sales'));

        } else {
            $this->dispatch('notify', ...['type' => 'error', 'content' => $message]);
        }
    }

    public function clearFields(): void
    {
        $this->sale->setDefaultValues();
    }

    public function mount($id = null): void
    {
        if (!is_null($id)) {
            $obj = Sale::on($this->getTenantConnection())->find($id);

            if ($obj) {
                $this->sale->loadValues($obj);
            } else {
                $this->sale->setDefaultValues();
            }
        } else {
            $this->sale->setDefaultValues();
        }
    }

    #region[add items]

    public function addItems(): void
    {
        $qty = (float)$this->saleItems->qty;
        $price = (float)$this->saleItems->price;
        $gstPercent = (float)$this->saleItems->gst_percent;

        if ($this->saleItems->itemIndex === '') {
            // Add new item
            if ($this->saleItems->product_name && $price && $qty) {
                $this->sale->itemList[] = $this->buildItemArray($qty, $price, $gstPercent);
            }
        } else {
            // Update existing item
            $index = $this->saleItems->itemIndex;
            $this->sale->itemList[$index] = $this->buildItemArray($qty, $price, $gstPercent);
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
            'po_no' => $this->saleItems->po_no,
            'dc_no' => $this->saleItems->dc_no,
            'no_of_roll' => $this->saleItems->no_of_roll,
            'product_name' => $this->saleItems->product_name,
            'product_id' => $this->saleItems->product_id,
            'colour_id' => $this->saleItems->colour_id,
            'colour_name' => $this->saleItems->colour_name,
            'size_id' => $this->saleItems->size_id,
            'size_name' => $this->saleItems->size_name,
            'qty' => $qty,
            'price' => $price,
            'gst_percent' => $gstPercent,
            'description' => $this->saleItems->description,
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
            $this->saleItems->{$field} = '';
        }

        $this->calculateTotal();
    }

    public function changeItems($index): void
    {
        if (!isset($this->sale->itemList[$index])) return;

        $item = $this->sale->itemList[$index];

        $this->saleItems->itemIndex = $index;

        foreach ($item as $key => $value) {
            $this->saleItems->{$key} = $value;
        }

        $this->dispatch('refresh-product-lookup', ['vname' => $this->saleItems->product_name]);
        $this->dispatch('refresh-colour-lookup', ['vname' => $this->saleItems->colour_name]);
        $this->dispatch('refresh-size-lookup', ['vname' => $this->saleItems->size_name]);

        $this->calculateTotal();
    }

    public function deleteItem($index): void
    {
        if (!isset($this->sale->itemList[$index])) {
            throw new Exception("Item at index {$index} does not exist.");
        }

        unset($this->sale->itemList[$index]);
        $this->sale->itemList = array_values($this->sale->itemList);
        $this->calculateTotal();
    }

    public function removeItems($index): void
    {
        unset($this->sale->itemList[$index]);
        $this->sale->itemList = array_values($this->sale->itemList);
        $this->calculateTotal();
    }

    #endregion


    #region[Calculate total]

    public function calculateTotal(): void
    {
        if (!empty($this->sale->itemList)) {

            // Reset all totals
            $totalQty = 0;
            $totalTaxable = 0;
            $totalGst = 0;
            $grandTotalBeforeRound = 0;

            // Loop through item list and accumulate values
            foreach ($this->sale->itemList as $row) {
                $totalQty += round((float)$row['qty'], 3);
                $totalTaxable += round((float)$row['taxable'], 2);
                $totalGst += round((float)$row['gst_amount'], 2);
                $grandTotalBeforeRound += round((float)$row['subtotal'], 2);
            }

            // Assign accumulated values
            $this->sale->total_qty = $totalQty;
            $this->sale->total_taxable = $totalTaxable;
            $this->sale->total_gst = $totalGst;
            $this->grandTotalBeforeRound = $grandTotalBeforeRound;

            // Grand total rounding
            $this->sale->grand_total = round($grandTotalBeforeRound);
            $this->sale->round_off = $this->sale->grand_total - $grandTotalBeforeRound;

            // Round-off fix (adjust negative if needed)
            if ($this->sale->round_off > 0) {
                $this->sale->round_off = -1 * round(abs($this->sale->round_off), 2);
            } else {
                $this->sale->round_off = round($this->sale->round_off, 2);
            }

            // Final grand total after adjustments
            $this->sale->grand_total = round($this->sale->grand_total + (float)($this->sale->additional ?? 0), 2);
        }
    }

    #endregion

    public function getRoute()
    {
        $this->redirect(route('sales'));
    }

    public function render()
    {
        return view('entries::sale.upsert');
    }
}

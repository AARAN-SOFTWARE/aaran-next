<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms\Purchase;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Models\Purchase;
use Aaran\BMS\Billing\Entries\Models\Purchaseitem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MainForm extends Form
{
    use TenantAwareTrait;

    public ?string $vid = null;

    public ?string $uniqueno = null;
    public ?string $acyear = null;
    public ?string $company_id = null;
    public ?string $contact_id = null;

    #[Validate]
    public ?string $purchase_no = null;
    public ?string $purchase_date = null;
    public ?string $entry_no = null;
    public ?string $entry_date = null;
    public ?string $purchase_type = null;
    public ?string $order_id = null;

    public string $billing_id = '';
    public ?string $shipping_id = null;
    public ?string $style_id = null;
    public ?string $job_no = null;

    public ?string $bundle = null;
    public ?string $trans_mode = '';
    public string $trans_id = '';
    public ?string $trans_docs = '';
    public ?string $trans_docs_dt = '';
    public string $distance = '';
    public string $veh_type = '';
    public string $veh_no = '';
    public string $term = '';


    public ?float $total_qty = null;
    public ?float $total_taxable = null;
    public ?float $total_gst = null;
    public mixed $ledger_id = '';
    public ?float $additional;
    public ?float $round_off = null;
    public ?float $grand_total = null;
    public mixed $received_by = '';
    public bool $active_id = true;


    public $itemList = [];

    #region[rules]
    public function rules(): array
    {
        return [
            'uniqueno' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.purchases,uniqueno"),
            'contact_id' => 'required',
            'order_id' => 'required',
            'style_id' => 'required',
            'entry_no' => 'required',
            'entry_date' => 'required|date',
            'purchase_no' => 'required',
            'purchase_date' => 'required|date',
            'purchase_type' => ['required', Rule::notIn(['0'])],
            'billing_id' => 'required',
            'shipping_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contact_id.required' => ' :attribute is required.',
            'order_id.required' => ' :attribute is required.',
            'style_id.required' => ' :attribute is required.',
            'purchase_type.required' => ' :attribute is required.',
            'purchase_no.required' => ' :attribute is required.',
            'purchase_date.required' => ' :attribute is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'contact_id' => 'party name',
            'order_id' => 'Order no',
            'style_id' => 'Style',
            'purchase_type' => 'Purchases type',
            'purchase_no' => 'Purchases bill No',
            'purchase_date' => 'Purchases bill Date',
        ];
    }

    #endregion

    public function setDefaultValues(): void
    {
        $this->entry_no = Purchase::nextNo($this->getTenantConnection());
        $this->entry_date = Carbon::now()->format('Y-m-d');

        $this->uniqueno = session('company_id') . '~' . session('acyear') . '~' . $this->entry_no;
        $this->purchase_type = '1';
        $this->trans_mode = '1';
        $this->trans_id = 1;
        $this->trans_docs = $this->entry_no;
        $this->trans_docs_dt = $this->entry_date;;
        $this->veh_type = 'R';
        $this->veh_no = '-';

        $this->additional = 0;

        $this->total_taxable = 0;
        $this->total_gst = 0;
        $this->round_off = 0;
        $this->grand_total = 0;

        $this->active_id = true;
    }

    public function loadValues($obj): void
    {
        $this->vid = $obj->id;
        $this->uniqueno = $obj->uniqueno;
        $this->acyear = $obj->acyear;
        $this->company_id = $obj->company_id;
        $this->contact_id = $obj->contact_id;
        $this->purchase_no = $obj->purchase_no;
        $this->purchase_date = $obj->purchase_date;
        $this->entry_no = $obj->entry_no;
        $this->entry_date = $obj->entry_date;
        $this->purchase_type = $obj->purchase_type;
        $this->order_id = $obj->order_id;
        $this->billing_id = $obj->billing_id;
        $this->shipping_id = $obj->shipping_id;
        $this->style_id = $obj->style_id;
        $this->job_no = $obj->job_no;
        $this->bundle = $obj->bundle;

        $this->trans_mode = $obj->trans_mode;
        $this->trans_id = $obj->trans_id ?: '1';
        $this->trans_docs = $obj->trans_docs;
        $this->trans_docs_dt = $obj->trans_docs_dt;
        $this->distance = $obj->distance ?: '0';
        $this->veh_type = $obj->veh_type;
        $this->veh_no = $obj->veh_no;
        $this->term = $obj->term;

        $this->total_qty = $obj->total_qty;
        $this->total_taxable = $obj->total_taxable;
        $this->total_gst = $obj->total_gst;
        $this->ledger_id = $obj->ledger_id ?: '1';
        $this->additional = $obj->additional;
        $this->round_off = $obj->round_off;
        $this->grand_total = $obj->grand_total;
        $this->received_by = $obj->received_by;
        $this->active_id = $obj->active_id;

        $this->loadItems($obj->id);
    }

    public function loadItems($id): void
    {
        $data = DB::connection($this->getTenantConnection())->table('purchase_items')
            ->select(
                'purchase_items.*',
                'products.vname as product_name',
                'colours.vname as colour_name',
                'sizes.vname as size_name'
            )
            ->join('products', 'products.id', '=', 'purchase_items.product_id')
            ->join('colours', 'colours.id', '=', 'purchase_items.colour_id')
            ->join('sizes', 'sizes.id', '=', 'purchase_items.size_id')
            ->where('purchase_items.purchase_id', $id)
            ->get()
            ->transform(function ($item) {
                $taxable = $item->qty * $item->price;
                $gstAmount = $taxable * ($item->gst_percent / 100);
                $subtotal = $taxable + $gstAmount;

                return [
                    'purchase_item_id' => $item->id,
                    'po_no' => $item->po_no,
                    'dc_no' => $item->dc_no,
                    'no_of_roll' => $item->no_of_roll,
                    'product_name' => $item->product_name,
                    'product_id' => $item->product_id,
                    'colour_name' => $item->colour_name,
                    'colour_id' => $item->colour_id,
                    'size_name' => $item->size_name,
                    'size_id' => $item->size_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'description' => $item->description,
                    'gst_percent' => $item->gst_percent,
                    'taxable' => $taxable,
                    'gst_amount' => $gstAmount,
                    'subtotal' => $subtotal,
                ];
            });

        $this->itemList = $data;
    }


    public function createOrUpdate(): string
    {
        $this->validate();

        $purchase = $this->vid
            ? Purchase::on($this->getTenantConnection())->findOrFail($this->vid)
            : new Purchase();

        // Assign the tenant connection
        $purchase->setConnection($this->getTenantConnection());

        // Assign ID only if updating
        if ($this->vid) {
            $purchase->id = $this->vid;
        }

        // === Basic Info ===
        $purchase->uniqueno = $this->uniqueno ?? session('company_id') . '~' . session('acyear_id') . '~' . $this->entry_no;
        $purchase->acyear = $this->acyear ?? session('acyear_id');
        $purchase->company_id = $this->company_id ?? session('company_id');
        $purchase->contact_id = $this->contact_id;
        $purchase->purchase_no = $this->purchase_no;
        $purchase->purchase_date = $this->purchase_date;
        $purchase->entry_no = $this->entry_no;
        $purchase->entry_date = $this->entry_date;
        $purchase->purchase_type = $this->purchase_type;
        $purchase->order_id = $this->order_id;
        $purchase->billing_id = $this->billing_id;
        $purchase->shipping_id = $this->shipping_id;
        $purchase->style_id = $this->style_id;
        $purchase->job_no = $this->job_no;
        $purchase->bundle = $this->bundle;

        // === Transport Info ===
        $purchase->trans_mode = $this->trans_mode;
        $purchase->trans_id = $this->trans_id ?? '1';
        $purchase->trans_docs = $this->trans_docs;
        $purchase->trans_docs_dt = $this->trans_docs_dt;
        $purchase->distance = $this->distance;
        $purchase->veh_type = $this->veh_type;
        $purchase->veh_no = $this->veh_no;

        $purchase->term = $this->term;
        $purchase->ledger_id = $this->ledger_id;
        $purchase->additional = $this->additional;
        $purchase->round_off = $this->round_off;
        $purchase->grand_total = $this->grand_total;
        $purchase->received_by = $this->received_by;
        $purchase->active_id = $this->active_id;

        // === Totals ===
        $purchase->total_qty = $this->total_qty;
        $purchase->total_taxable = $this->total_taxable;
        $purchase->total_gst = $this->total_gst;

        // Save with tenant connection
        $purchase->save();

        // Use the correct ID after save
        return $this->createOrUpdateItem($purchase->id);
    }

    public function createOrUpdateItem($purchaseId): string
    {
        try {
            DB::connection($this->getTenantConnection())
                ->table('purchase_items')
                ->where('purchase_id', $purchaseId)
                ->delete();
        } catch (\Exception $e) {
            Log::error("Failed to delete purchase items for purchase_id {$purchaseId}: " . $e->getMessage());
            throw $e;
        }

        foreach ($this->itemList as $item) {
            PurchaseItem::on($this->getTenantConnection())->create([
                'purchase_id' => $purchaseId,
                'po_no' => $item['po_no'],
                'dc_no' => $item['dc_no'],
                'no_of_roll' => $item['no_of_roll'],
                'product_id' => $item['product_id'],
                'colour_id' => $item['colour_id'] ?? '1',
                'size_id' => $item['size_id'] ?? '1',
                'qty' => $item['qty'],
                'price' => $item['price'],
                'gst_percent' => $item['gst_percent'],
                'description' => $item['description'],
            ]);
        }

        return 'success';
    }
}

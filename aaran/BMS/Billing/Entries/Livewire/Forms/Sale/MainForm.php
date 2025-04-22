<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms\Sale;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Models\Sale;
use Aaran\BMS\Billing\Entries\Models\SaleItem;
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
    public ?string $invoice_no = null;
    public ?string $invoice_date = null;
    public ?string $sales_type = null;
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
            'uniqueno' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.sales,uniqueno"),
            'contact_id' => 'required',
            'order_id' => 'required',
            'style_id' => 'required',
            'invoice_no' => 'required',
            'invoice_date' => 'required|date',
            'sales_type' => ['required', Rule::notIn(['0'])],

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
            'sales_type.required' => ' :attribute is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'contact_id' => 'party name',
            'order_id' => 'Order no',
            'style_id' => 'Style',
            'sales_type' => 'Sales type',
        ];
    }

    #endregion

    public function setDefaultValues(): void
    {
        $this->invoice_no = Sale::nextNo($this->getTenantConnection());
        $this->invoice_date = Carbon::now()->format('Y-m-d');

        $this->uniqueno = session('company_id') . '~' . session('acyear_id') . '~' . $this->invoice_no;
        $this->sales_type = '1';
        $this->trans_mode = '1';
        $this->trans_id = 1;
        $this->trans_docs = $this->invoice_no;
        $this->trans_docs_dt = $this->invoice_date;;
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
        $this->invoice_no = $obj->invoice_no;
        $this->invoice_date = $obj->invoice_date;
        $this->sales_type = $obj->sales_type;
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
        $data = DB::connection($this->getTenantConnection())->table('sale_items')
            ->select(
                'sale_items.*',
                'products.vname as product_name',
                'colours.vname as colour_name',
                'sizes.vname as size_name'
            )
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->join('colours', 'colours.id', '=', 'sale_items.colour_id')
            ->join('sizes', 'sizes.id', '=', 'sale_items.size_id')
            ->where('sale_items.sale_id', $id)
            ->get()
            ->transform(function ($item) {
                $taxable = $item->qty * $item->price;
                $gstAmount = $taxable * ($item->gst_percent / 100);
                $subtotal = $taxable + $gstAmount;

                return [
                    'sale_item_id' => $item->id,
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

        $sale = $this->vid
            ? Sale::on($this->getTenantConnection())->findOrFail($this->vid)
            : new Sale();

        // Assign the tenant connection
        $sale->setConnection($this->getTenantConnection());

        // Assign ID only if updating
        if ($this->vid) {
            $sale->id = $this->vid;
        }

        // === Basic Info ===
        $sale->uniqueno = $this->uniqueno ?? session('company_id') . '~' . session('acyear_id') . '~' . $this->invoice_no;
        $sale->acyear = $this->acyear ?? session('acyear_id');
        $sale->company_id = $this->company_id ?? session('company_id');
        $sale->contact_id = $this->contact_id;
        $sale->invoice_no = $this->invoice_no;
        $sale->invoice_date = $this->invoice_date ?? now()->format('Y-m-d');
        $sale->sales_type = $this->sales_type;
        $sale->order_id = $this->order_id;
        $sale->billing_id = $this->billing_id;
        $sale->shipping_id = $this->shipping_id;
        $sale->style_id = $this->style_id;
        $sale->job_no = $this->job_no;
        $sale->bundle = $this->bundle;

        // === Transport Info ===
        $sale->trans_mode = $this->trans_mode;
        $sale->trans_id = $this->trans_id ?? '1';
        $sale->trans_docs = $this->trans_docs;
        $sale->trans_docs_dt = $this->trans_docs_dt;
        $sale->distance = $this->distance;
        $sale->veh_type = $this->veh_type;
        $sale->veh_no = $this->veh_no;

        $sale->term = $this->term;
        $sale->ledger_id = $this->ledger_id;
        $sale->additional = $this->additional;
        $sale->round_off = $this->round_off;
        $sale->grand_total = $this->grand_total;
        $sale->received_by = $this->received_by;
        $sale->active_id = $this->active_id;

        // === Totals ===
        $sale->total_qty = $this->total_qty;
        $sale->total_taxable = $this->total_taxable;
        $sale->total_gst = $this->total_gst;

        // Save with tenant connection
        $sale->save();

        // Use the correct ID after save
        return $this->createOrUpdateItem($sale->id);
    }

    public function createOrUpdateItem($saleId): string
    {
        try {
            DB::connection($this->getTenantConnection())
                ->table('sale_items')
                ->where('sale_id', $saleId)
                ->delete();
        } catch (\Exception $e) {
            Log::error("Failed to delete sale items for sale_id {$saleId}: " . $e->getMessage());
            throw $e;
        }

        foreach ($this->itemList as $item) {
            SaleItem::on($this->getTenantConnection())->create([
                'sale_id' => $saleId,
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

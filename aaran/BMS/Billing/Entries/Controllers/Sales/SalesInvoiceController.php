<?php

namespace Aaran\BMS\Billing\Entries\Controllers\Sales;

use Aaran\Assets\Helper\ConvertTo;
use Aaran\Assets\Traits\TenantAwareTrait;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SalesInvoiceController extends Controller
{
    use TenantAwareTrait;

    public function __invoke($vid)
    {
        if ($vid != '') {
            $connection = $this->getTenantConnection();

            $sale = $this->getSales($vid, $connection);

            if (!$sale) {
                abort(404, "Sale not found");
            }

            Pdf::setOption([
                'dpi' => 150,
                'defaultPaperSize' => 'a4',
                'defaultFont' => 'sans-serif',
                'fontDir'
            ]);

            $pdf = PDF::loadView('entries-pdf::Sales.offset', [
                'obj' => $sale,
                'rupees' => ConvertTo::ruppesToWords($sale->grand_total),
                'list' => $this->getSaleItems($vid, $connection),
                'cmp' => $this->getCompany($connection),
                'billing_address' => $this->getBillingAddress($sale->billing_id, $connection),
                'shipping_address' => $this->getBillingAddress($sale->shipping_id, $connection),
            ]);

            $pdf->render();

            return $pdf->stream($sale->invoice_no);
        }

        return null;
    }

    public function getSales($vid, $connection): ?object
    {
        $sale = DB::connection($connection)->table('sales')
            ->select(
                'sales.*',
                'contacts.vname as contact_name',
                'contacts.msme_no as msme_no',
                'contacts.msme_type_id as msme_type',
                'orders.vname as order_no',
                'orders.order_name as order_name',
                'styles.vname as style_name',
                'styles.description as style_desc',
                'transports.vname as transport_name',
                'ledgers.vname as ledger_name'
            )
            ->leftJoin('contacts', 'contacts.id', '=', 'sales.contact_id')
            ->leftJoin('orders', 'orders.id', '=', 'sales.order_id')
            ->leftJoin('styles', 'styles.id', '=', 'sales.style_id')
            ->leftJoin('transports', 'transports.id', '=', 'sales.trans_id')
            ->leftJoin('ledgers', 'ledgers.id', '=', 'sales.ledger_id')
            ->where('sales.id', '=', $vid)
            ->first();

        if (!$sale) {
            abort(404, "Sale not found");
        }

        return $sale;
    }

    public function getSaleItems($vid, $connection): Collection
    {
        return DB::connection($connection)->table('sale_items')
            ->select(
                'sale_items.*',
                'products.vname as product_name',
                'units.vname as product_unit',
                'hsncodes.vname as hsncode',
                'colours.vname as colour_name',
                'sizes.vname as size_name',
            )
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->join('hsncodes', 'hsncodes.id', '=', 'products.hsncode_id')
            ->join('units', 'units.id', '=', 'products.unit_id')
            ->join('colours', 'colours.id', '=', 'sale_items.colour_id')
            ->join('sizes', 'sizes.id', '=', 'sale_items.size_id')
            ->where('sale_id', '=', $vid)
            ->get()
            ->transform(function ($data) {
                return [
                    'saleitem_id' => $data->id,
                    'product_id' => $data->product_id,
                    'po_no' => $data->po_no,
                    'dc_no' => $data->dc_no,
                    'no_of_roll' => $data->no_of_roll,
                    'product_name' => $data->product_name,
                    'product_unit' => $data->product_unit,
                    'hsncode' => $data->hsncode,
                    'colour_id' => $data->colour_id,
                    'colour_name' => $data->colour_name,
                    'size_id' => $data->size_id,
                    'size_name' => $data->size_name,
                    'description' => $data->description,
                    'qty' => $data->qty,
                    'price' => $data->price,
                    'total_taxable' => number_format($data->qty * $data->price, 2, '.', ''),
                    'gst_percent' => $data->gst_percent / 2,
                    'gst_amount' => number_format(($data->qty * $data->price) * (($data->gst_percent) / 100), 2, '.', ''),
                    'sub_total' => number_format((($data->qty * $data->price) * ($data->gst_percent / 100)) + ($data->qty * $data->price), 2, '.', ''),
                ];
            });
    }

    public function getCompany($connection)
    {
        return DB::connection($connection)->table('companies')
            ->select(
                'companies.*',
                'cities.vname as city_name',
                'states.vname as state_name',
                'pincodes.vname as pincode_name',
                'countries.vname as country_name',
            )
            ->leftJoin('cities', 'cities.id', '=', 'companies.city_id')
            ->leftJoin('states', 'states.id', '=', 'companies.state_id')
            ->leftJoin('pincodes', 'pincodes.id', '=', 'companies.pincode_id')
            ->leftJoin('countries', 'countries.id', '=', 'companies.country_id')
            ->where('companies.id', '=', session('company_id'))
            ->first();
    }

    public function getBillingAddress($vid, $connection): object
    {
        $obj = DB::connection($connection)->table('contact_addresses')
            ->select(
                'contact_addresses.*',
                'cities.vname as city_name',
                'states.vname as state_name',
                'states.state_code as state_code',
                'pincodes.vname as pincode_name',
                'contacts.gstin as gstin',
                'contacts.email as email',
                'countries.vname as country_name',
            )
            ->leftJoin('cities', 'cities.id', '=', 'contact_addresses.city_id')
            ->leftJoin('states', 'states.id', '=', 'contact_addresses.state_id')
            ->leftJoin('pincodes', 'pincodes.id', '=', 'contact_addresses.pincode_id')
            ->leftJoin('countries', 'countries.id', '=', 'contact_addresses.country_id')
            ->leftJoin('contacts', 'contacts.id', '=', 'contact_addresses.contact_id')
            ->where('contact_addresses.id', '=', $vid)
            ->first();

        return (object)[
            'address_1' => $obj->address_1,
            'address_2' => $obj->address_2,
            'address_3' => $obj->city_name . ' - ' . $obj->pincode_name . '.  ' . $obj->state_name .' -'. $obj->state_code,
            'country' => $obj->country_name,
            'gst_cell' => 'GSTin : ' . $obj->gstin,
            'gstContact' => $obj->gstin,
            'email' => $obj->email,
        ];
    }

}

<?php

namespace Aaran\BMS\Billing\Reports\Livewire\Class\Sales;

use Aaran\Assets\Trait\CommonTraitNew;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\Entries\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MonthlyReport extends Component
{
    use CommonTraitNew;

    #region[properties]
    public $month;
    public $year;
    public $filterField;
    public $filterValue;
    public $contects;
    #endregion

    #region[create]
    public function monthlyReport($month)
    {
        $this->month = $month;
        $this->year = $this->year?:Carbon::now()->format('Y');
    }
    #endregion

    #region[create]
    public function create(): void
    {
        ini_set('max_execution_time', 3600);
        $this->redirect(route('sales.upsert', ['0']));
    }
    #endregion

    #region[getList]
    public function getList()
    {
        $sales = Sale::whereMonth('invoice_date', '=', $this->month ?: Carbon::now()->format('m'))
            ->whereYear('invoice_date', '=', $this->year ?: Carbon::now()->format('Y'))
            ->where('company_id', '=', session()->get('company_id'))
            ->get();
        $salesData = [];
        foreach ($sales as $sale) {
            $percentString = $this->getPercent($sale->id, $sale->sales_type);
            $salesData[] = [
                'sale' => $sale,
                'percent' => $percentString,
                'contact_name' => $sale->contact->vname,
                'contact_gstin' => $sale->contact->gstin,
            ];
        }
        return $salesData;
    }

    public function getPercent($id, $salesType)
    {
        $obj = DB::table('saleitems')
            ->select('saleitems.product_id')
            ->where('saleitems.sale_id', $id)
            ->distinct()
            ->get();
        $data = [];
        foreach ($obj as $item) {
            $product = DB::table('products')
                ->select('products.hsncode_id', 'products.gstpercent_id')
                ->where('id', $item->product_id)
                ->first();
//            if ($product) {
//                $data[] = $salesType == '1'
//                    ? 'HSN Code - '.Common::name($product->hsncode_id).' - '.(Common::name($product->gstpercent_id) / 2).'%'
//                    : 'HSN Code - '.Common::name($product->hsncode_id).' - '.Common::name($product->gstpercent_id).'%';
//            }
        }
        return implode(', ', $data);
    }
    #endregion

    #region[monthlySales]
    public function monthlySales($month)
    {
        return Sale::whereMonth('invoice_date', '=', $month)
            ->whereYear('invoice_date', '=', $this->year ?: Carbon::now()->format('Y'))
            ->where('company_id', '=', session()->get('company_id'))->sum('grand_total');
    }

    #endregion

    public function getSales()
    {
        return Sale::where('company_id', '=', session()->get('company_id'))->when($this->filterValue,
            function ($query, $filterValue) {
                return $query->where($this->filterField ?: 'invoice_no', '=', $filterValue);
            })->get();
    }

    public function getContects()
    {
        $this->contects = Contact::where('company_id', '=', session()->get('company_id'))->get();
    }

    public function clearFilter(): void
    {
        $this->filterValue = '';
    }

    public function printMonthly()
    {
        return $this->redirect(route('monthlySalesReport.print',
            [
                'month' => $this->month ?: Carbon::now()->format('m'),
                'year' => $this->year ?: Carbon::now()->format('Y')
            ]));
    }

    public function printSummary()
    {
        return $this->redirect(route('summary.print', ['year' => $this->year ?: Carbon::now()->format('Y')]));
    }

    public function render()
    {
        $this->getContects();
        return view('reports::Sales.monthly-report')->with([
            'list' => $this->getList(), 'salesAll' => $this->getSales(),
        ]);
    }
}

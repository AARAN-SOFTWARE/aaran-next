<?php

namespace Aaran\BMS\Billing\Reports\Controllers\Sales;

use Aaran\Common\Models\GstPercent;
use Aaran\Entries\Models\Sale;
use Aaran\BMS\Billing\Master\Models\Company;
use Aaran\BMS\Billing\Master\Models\Product;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyReportController extends Controller
{
    public function __invoke($month,$year)
    {
        $monthReport=$this->getList($month,$year);
//        return pdf('pdf-view.report.sales.monthly-report', [
            Pdf::setOption(['dpi' => 150, 'defaultPaperSize' => 'a4', 'defaultFont' => 'sans-serif','fontDir']);

        $pdf = PDF::loadView('aaran-ui::components.pdf-view.report.sales.monthly-report'
            , [
            'list'=>$monthReport,
            'cmp' => Company::printDetails(session()->get('company_id')),
        ])->setPaper('A4', 'landscape');

        $pdf->render();
        return $pdf->stream();
    }

    public static function getPercent($id,$salesType)
    {
        $obj=DB::table('saleitems')
            ->select('saleitems.product_id')
            ->where('saleitems.sale_id', $id)
            ->distinct()->get();
        foreach ($obj as $item) {
            $product=Product::find($item->product_id);
            $data[]= $salesType=='1'?
                (GstPercent::find($product->gstpercent_id)->vname/2).'%':
                GstPercent::find($product->gstpercent_id)->vname.'%';
        }
        $dataString = implode(', ', $data);
        return $dataString;
    }

    public function getList($month,$year)
    {
        return Sale::whereMonth('invoice_date','=',$month)->whereYear('invoice_date','=',$year?:Carbon::now()->format('Y'))
            ->where('company_id','=',session()->get('company_id'))->get();
    }

}

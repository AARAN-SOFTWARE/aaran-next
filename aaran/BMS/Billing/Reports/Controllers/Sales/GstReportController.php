<?php

namespace Aaran\BMS\Billing\Reports\Controllers\Sales;

use Aaran\Entries\Models\Purchase;
use Aaran\Entries\Models\Sale;
use Aaran\BMS\Billing\Master\Models\Company;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class GstReportController extends Controller
{
    public function __invoke($month,$year)
    {

//        return pdf('pdf-view.report.sales.gst-report', [
        Pdf::setOption(['dpi' => 150, 'defaultPaperSize' => 'a4', 'defaultFont' => 'sans-serif','fontDir']);

        $pdf = PDF::loadView('aaran-ui::components.pdf-view.report.sales.gst-report'
            , [
            'sales'=>$this->getSales($month,$year),
            'purchase'=>$this->getPurchase($month,$year),
            'cmp' => Company::printDetails(session()->get('company_id')),
        ]);
        $pdf->render();

        return $pdf->stream();
    }

    public function getSales($month,$year)
    {
        return Sale::whereMonth('invoice_date','=',$month?:Carbon::now()->format('m'))
            ->whereYear('invoice_date','=',$year?:Carbon::now()->format('Y'))
            ->where('company_id','=',session()->get('company_id'))->get();
    }

    public function getPurchase($month,$year)
    {
        return Purchase::whereMonth('purchase_date','=',$month?:Carbon::now()->format('m'))
            ->whereYear('purchase_date','=',$year?:Carbon::now()->format('Y'))
            ->where('company_id','=',session()->get('company_id'))->get();
    }
}

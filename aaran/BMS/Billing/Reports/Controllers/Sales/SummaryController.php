<?php

namespace Aaran\BMS\Billing\Reports\Controllers\Sales;

use Aaran\Entries\Models\Sale;
use Aaran\BMS\Billing\Master\Models\Company;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class SummaryController extends Controller
{
    public function __invoke($year)
    {
//        return pdf('pdf-view.report.sales.summary-report', [
            Pdf::setOption(['dpi' => 150, 'defaultPaperSize' => 'a4', 'defaultFont' => 'sans-serif','fontDir']);

        $pdf = PDF::loadView('aaran-ui::components.pdf-view.report.sales.summary-report'
            , [
            'year' => $year,
            'cmp' => Company::printDetails(session()->get('company_id')),
        ]);
        $pdf->render();

        return $pdf->stream();
    }

    #region[monthlySales]
    public static function monthlySales($month,$year)
    {
        return Sale::whereMonth('invoice_date','=',$month)
            ->whereYear('invoice_date','=',$year?:Carbon::now()->format('Y'))
            ->where('company_id','=',session()->get('company_id'))->sum('grand_total');
    }
    #endregion

}

<?php

namespace Aaran\Dashboard\Livewire\Class;

use Aaran\Assets\Enums\TransactionMode;
use Aaran\Assets\Helper\ConvertTo;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Models\Purchase;
use Aaran\BMS\Billing\Entries\Models\Sale;
use Aaran\BMS\Billing\Transaction\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Index extends Component
{
    use TenantAwareTrait;

    public $blogs;
    public $transactions;
    public $entries;
    public $contacts;

    public function mount()
    {
        $this->getDefaultCompany();
        $this->contacts = $this->getContacts();
        $this->transactions = $this->getTransactions();
        $this->entries = $this->getEntries();
        $this->blogs = $this->getBlog();
    }

    public function getContacts()
    {
        return DB::connection($this->getTenantConnection())
            ->table('contacts')
            ->orderBy('contacts.outstanding', 'desc')
            ->limit(20)
            ->get();
    }

    public function getTransactions()
    {
        $first = Carbon::now()->startOfMonth()->toDateString();
        $last = Carbon::now()->endOfMonth()->toDateString();

        $db = DB::connection($this->getTenantConnection());
        $acyear = session('acyear_id');
        $company = session('company_id');

        // Helper to DRY up sum logic
        $sum = fn($table, $column, $filters = []) => $db->table($table)->where('acyear', $acyear)
            ->where('company_id', $company)
            ->when(!empty($filters), fn($q) => $q->where($filters))
            ->sum($column);

        // Get values
        $total_sales = $sum('sales', 'grand_total');

        $month_sales = $db->table('sales')
            ->where('acyear', $acyear)
            ->where('company_id', $company)
            ->whereBetween('invoice_date', [$first, $last])
            ->sum('grand_total');

        $total_purchase = $sum('purchases', 'grand_total');

        $month_purchase = $db->table('purchases')
            ->where('acyear', $acyear)
            ->where('company_id', $company)
            ->whereBetween('purchase_date', [$first, $last])
            ->sum('grand_total');


        $total_receivable = $db->table('transactions')
            ->where('acyear', $acyear)
            ->where('company_id', $company)
            ->where('transaction_mode', TransactionMode::RECEIPT)
            ->sum('amount');

        $month_receivable = $db->table('transactions')
            ->where('acyear', $acyear)
            ->where('company_id', $company)
            ->where('transaction_mode', TransactionMode::RECEIPT)
            ->whereBetween('vdate', [$first, $last])
            ->sum('amount');


        $total_payable = $db->table('transactions')
            ->where('acyear', $acyear)
            ->where('company_id', $company)
            ->where('transaction_mode', TransactionMode::PAYMENT)
            ->sum('amount');

        $month_payable = $db->table('transactions')
            ->where('acyear', $acyear)
            ->where('company_id', $company)
            ->where('transaction_mode', TransactionMode::PAYMENT)
            ->whereBetween('vdate', [$first, $last])
            ->sum('amount');


        return Collection::make([
            'total_sales' => ConvertTo::rupeesFormat($total_sales),
            'month_sales' => ConvertTo::rupeesFormat($month_sales),
            'total_purchase' => ConvertTo::rupeesFormat($total_purchase),
            'month_purchase' => ConvertTo::rupeesFormat($month_purchase),

            'total_receivable' => ConvertTo::rupeesFormat($total_sales - $total_receivable),
            'month_receivable' => ConvertTo::rupeesFormat($month_sales - $month_receivable),

            'total_payable' => ConvertTo::rupeesFormat( $total_purchase - $total_payable),
            'month_payable' => ConvertTo::rupeesFormat($month_purchase-$month_payable),

            'net_profit' => ConvertTo::rupeesFormat(($total_sales - $total_purchase) ?? 0),
            'month_profit' => ConvertTo::rupeesFormat(($month_sales - $month_purchase) ?? 0),
        ]);
    }


    public function getEntries()
    {
        $sales = Sale::on($this->getTenantConnection())->latest()->first();
        $purchase = Purchase::on($this->getTenantConnection())->latest()->first();
        $payment = Transaction::on($this->getTenantConnection())->latest()->where('transaction_mode', '=', TransactionMode::PAYMENT)->first();
        $receipt = Transaction::on($this->getTenantConnection())->latest()->where('transaction_mode', '=', TransactionMode::RECEIPT)->first();

        return Collection::make([
            'sales' => ConvertTo::rupeesFormat($sales->grand_total ?? 0),
            'sales_no' => $sales->invoice_no ?? 0,
            'sales_date' => $sales->invoice_date ?? '-',

            'purchase' => ConvertTo::rupeesFormat($purchase->grand_total ?? 0),
            'purchase_no' => $purchase->purchase_no ?? 0,
            'purchase_date' => $purchase->purchase_date ?? '-',

            'payment' => ConvertTo::rupeesFormat($payment->amount ?? 0),
            'payment_no' => $payment->vch_no ?? 0,
            'payment_date' => $payment->vdate ?? '-',

            'receipt' => ConvertTo::rupeesFormat($receipt->amount ?? 0),
            'receipt_no' => $receipt->vch_no ?? 0,
            'receipt_date' => $receipt->vdate ?? '-',
        ]);
    }


    public function getDefaultCompany(): void
    {
        $defaultCompany = DB::connection($this->getTenantConnection())
            ->table('default_companies')
            ->join('companies', 'default_companies.company_id', '=', 'companies.id')
            ->where('default_companies.id', '1')->first();

        session()->put('company_id', $defaultCompany->company_id);
        session()->put('company_name', $defaultCompany->vname);
        session()->put('acyear_id', $defaultCompany->acyear_id);
    }

    public function getBlog()
    {
//        $response = Http::get('https://cloud.aaranassociates.com/api/v1/blog');
//        $this->blogs = $response->json();

        try {
            $response = Http::get('https://cloud.aaranassociates.com/api/v1/blog');

            // Check if the response is successful
            if ($response->successful()) {
                // Process the response
                return $response->json();
                // Handle your data here
            } else {
                // Handle different response codes
                switch ($response->status()) {
                    case 404:
                        echo "Error 404: Not Found. The requested resource could not be found.";
                        break;
                    case 503:
                        echo "Error 503: Service Unavailable. Please try again later.";
                        break;
                    default:
                        echo "Error {$response->status()}: Something went wrong.";
                        break;
                }
            }
        } catch (\Exception $e) {
            // Log the exception message
            error_log($e->getMessage());
//            echo "An error occurred while trying to access the API: " . $e->getMessage();
        }

        return [];
    }


    public function render()
    {
        return view('dashboard::index');
    }

}

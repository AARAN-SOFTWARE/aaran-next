<?php

namespace Aaran\BMS\Billing\Transaction\Models;

use Aaran\BMS\Billing\Common\Models\Bank;
use Aaran\BMS\Billing\Common\Models\PaymentMode;
use Aaran\BMS\Billing\Common\Models\ReceiptType;
use Aaran\BMS\Billing\Common\Models\TransactionType;
use Aaran\BMS\Billing\Master\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{

    protected $guarded = [];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class,'contact_id','id');
    }

    public function accountBook(): BelongsTo
    {
        return $this->belongsTo(AccountBook::class, 'account_book_id','id');
    }

    public function transType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id','id');
    }

    public function receiptType(): BelongsTo
    {
        return $this->belongsTo(ReceiptType::class, 'receipt_type_id','id');
    }

    public function paymentMode(): BelongsTo
    {
        return $this->belongsTo(PaymentMode::class, 'payment_mode_id','id');

    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'instrument_bank_id','id');

    }

    public static function nextNo($value)
    {
        return
            static::where('mode_id', '=', $value)
                ->max('vch_no') + 1;
    }
}

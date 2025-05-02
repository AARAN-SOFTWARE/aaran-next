<?php

namespace Aaran\ExternalPartners\Razorpay\Models;

use Illuminate\Database\Eloquent\Model;
class RazorPayment  extends Model
{
    protected $fillable = [
        'order_id',
        'payment_id',
        'signature',
        'amount',
        'currency',
        'status',
        'method',
        'email',
        'contact',
        'description',
        'tenant_id',
        'user_id',
    ];

}

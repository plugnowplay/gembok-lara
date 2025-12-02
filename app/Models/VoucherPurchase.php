<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherPurchase extends Model
{
    protected $fillable = [
        'voucher_pricing_id',
        'phone_number',
        'price',
        'status',
        'payment_method',
        'payment_reference',
        'voucher_code',
        'voucher_password',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function pricing()
    {
        return $this->belongsTo(VoucherPricing::class, 'voucher_pricing_id');
    }
}

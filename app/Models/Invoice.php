<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'package_id',
        'amount',
        'tax_amount',
        'description',
        'status',
        'due_date',
        'paid_date',
        'invoice_number',
        'invoice_type',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
        'amount' => 'integer',
        'tax_amount' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->amount + $this->tax_amount;
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isOverdue()
    {
        return $this->status === 'unpaid' && $this->due_date && $this->due_date->isPast();
    }
}

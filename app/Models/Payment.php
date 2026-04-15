<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'payment_number',
        'order_id',
        'amount_paid',
        'change_amount',
        'payment_method',
        'status',
        'reference_number',
        'notes',
        'paid_at',
    ];
 
    protected $casts = [
        'amount_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];
 
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
 
    public static function generatePaymentNumber(): string
    {
        $prefix = 'PAY-' . date('Ymd') . '-';
        $last = self::where('payment_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();
 
        if ($last) {
            $lastNum = (int) substr($last->payment_number, -4);
            return $prefix . str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        }
 
        return $prefix . '0001';
    }
 
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'paid' => 'badge-paid',
            'partial' => 'badge-partial',
            default => 'badge-unpaid',
        };
    }
 
    public function getPaymentMethodLabel(): string
    {
        return match($this->payment_method) {
            'gcash' => 'GCash',
            'bank_transfer' => 'Bank Transfer',
            'other' => 'Other',
            default => 'Cash',
        };
    }
}

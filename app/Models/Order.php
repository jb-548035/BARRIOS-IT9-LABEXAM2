<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     use HasFactory;
 
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total_amount',
        'status',
        'notes',
    ];
 
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
 
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
 
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . date('Ymd') . '-';
        $lastOrder = self::where('order_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();
 
        if ($lastOrder) {
            $lastNum = (int) substr($lastOrder->order_number, -4);
            return $prefix . str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        }
 
        return $prefix . '0001';
    }
 
    public function calculateTotal(): float
    {
        return $this->orderItems->sum('subtotal');
    }
 
    public function isPaid(): bool
    {
        return $this->payment && $this->payment->status === 'paid';
    }
 
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'confirmed' => 'badge-confirmed',
            'completed' => 'badge-completed',
            'cancelled' => 'badge-cancelled',
            default => 'badge-pending',
        };
    }
}

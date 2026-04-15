<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiceItem extends Model
{
    use HasFactory;

    protected $table = 'rice_items';

    protected $fillable = [
        'name',
        'price_per_kg',
        'stock_quantity',
        'description',
        'is_available',
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'stock_quantity' => 'decimal:2',
        'is_available' => 'boolean',
    ];
 
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
 
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock_quantity', '>', 0);
    }
 
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0 && $this->is_available;
    }
 
    public function reduceStock(float $quantity): void
    {
        $this->decrement('stock_quantity', $quantity);
    }
}

<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'order_number',
        'full_name',
        'phone',
        'wilaya_id',
        'commune_id',
        'wilaya',
        'commune',
        'address',
        'notes',
        'status',
        'items_total',
        'delivery_price',
        'total',
    ];

    protected $attributes = [
        'status' => 'pending',
        'items_total' => 0,
        'delivery_price' => 0,
        'total' => 0,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'items_total' => 'decimal:2',
            'delivery_price' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function deliveryWilaya(): BelongsTo
    {
        return $this->belongsTo(Wilaya::class);
    }

    public function deliveryCommune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}

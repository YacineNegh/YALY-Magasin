<?php

namespace App\Models;

use Database\Factories\WilayaFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wilaya extends Model
{
    /** @use HasFactory<WilayaFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'name_ar',
        'delivery_price',
        'is_delivery_available',
    ];

    protected $attributes = [
        'delivery_price' => 0,
        'is_delivery_available' => true,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'code' => 'integer',
            'delivery_price' => 'decimal:2',
            'is_delivery_available' => 'boolean',
        ];
    }

    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class);
    }

    public function scopeDeliveryAvailable(Builder $query): Builder
    {
        return $query->where('is_delivery_available', true);
    }
}

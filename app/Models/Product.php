<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'stock',
        'description',
        'specifications',
        'status',
        'is_featured',
    ];

    protected $attributes = [
        'status' => 'active',
        'is_featured' => false,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query
            ->active()
            ->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->active());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function imageUrl(): string
    {
        $image = $this->images->first();

        if (! $image) {
            return '';
        }

        if (Str::startsWith($image->image_path, ['http://', 'https://'])) {
            return $image->image_path;
        }

        return Storage::disk('public')->url($image->image_path);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

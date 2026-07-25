<?php

namespace App\Models;

use Database\Factories\CommuneFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commune extends Model
{
    /** @use HasFactory<CommuneFactory> */
    use HasFactory;

    protected $fillable = [
        'wilaya_id',
        'geoalgeria_id',
        'name',
        'name_ar',
        'daira_name',
        'postal_code',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'geoalgeria_id' => 'integer',
        ];
    }

    public function wilaya(): BelongsTo
    {
        return $this->belongsTo(Wilaya::class);
    }
}

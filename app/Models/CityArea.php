<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityArea extends Model
{
    use HasFactory;

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'city_id',
        'name',
        'zip_code',
    ];

    /**
     * Get the city of the city area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the locations for the city area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}

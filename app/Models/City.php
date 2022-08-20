<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the city areas for the city.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cityAreas()
    {
        return $this->hasMany(CityArea::class);
    }
}

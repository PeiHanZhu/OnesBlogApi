<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasUser, HasFactory;

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'user_id',
        'city_area_id',
        'category_id',
        'name',
        'address',
        'phone',
        'avgScore',
        'introduction',
    ];

    /**
     * Get the city area of the location.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cityArea()
    {
        return $this->belongsTo(CityArea::class);
    }
}

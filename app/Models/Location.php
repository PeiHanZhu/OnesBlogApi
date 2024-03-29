<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use App\Traits\FileHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasUser, FileHandler, HasFactory;

    /**
     * @inheritDoc
     */
    protected static function booted()
    {
        static::deleted(function ($model) {
            static::deleteDirectory($model);
        });
    }

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
        'active',
        'images',
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'images' => 'array',
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

    /**
     * Get the location scores for the location.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationScores()
    {
        return $this->hasMany(LocationScore::class);
    }

    /**
     * Get the location service hours for the location.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationServiceHours()
    {
        return $this->hasMany(LocationServiceHour::class);
    }

    /**
     * Get the location likes for the location.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationLikes()
    {
        return $this->hasMany(LocationLike::class);
    }
}

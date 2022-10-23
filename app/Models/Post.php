<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use App\Traits\FileHandler;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasUser, FileHandler, HasFactory, Sluggable;

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
        'location_id',
        'title',
        'content',
        'published_at',
        'active',
        'slug',
        'images'
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }

    /**
     * Get the location of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the comments for the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the post keeps for the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postKeeps()
    {
        return $this->hasMany(PostKeep::class);
    }
}

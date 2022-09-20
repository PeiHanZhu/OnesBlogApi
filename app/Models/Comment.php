<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use App\Traits\FileHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
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
        'post_id',
        'content',
        'images',
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Get the post of the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

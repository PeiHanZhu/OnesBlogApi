<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasUser, HasFactory;

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
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

    /**
     * Get the comment images for the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentImages()
    {
        return $this->hasMany(commentImage::class);
    }
}

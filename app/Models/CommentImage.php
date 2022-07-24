<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentImage extends Model
{
    use HasFactory;

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'comment_id',
        'path',
    ];

    /**
     * Get the comment of the comment images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment() {
        return $this->belongsTo(Comment::class);
    }
}

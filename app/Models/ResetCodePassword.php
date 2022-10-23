<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetCodePassword extends Model
{
    use HasFactory;

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'code',
        'email',
        'expires_at',
    ];

    /**
     * @inheritDoc
     */
    protected $hidden = [
        'code',
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * @inheritDoc
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            !is_null($model->expires_at) ?: $model->expires_at = now()->addHours(1);
            $model->where('email', $model->email)->delete();
        });
    }
}

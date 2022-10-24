<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'login_type_id',
        'location_applied_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'location_applied_at' => 'datetime',
    ];

    /**
     * Get the posts for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the posts for the store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storePosts()
    {
        return $this->hasMany(Post::class, 'location_id');
    }

    /**
     * Get the comments for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the location for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne(Location::class);
    }

    /**
     * Get the location scores for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationScores()
    {
        return $this->hasMany(LocationScore::class);
    }

    /**
     * Get the location likes for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationLikes()
    {
        return $this->hasMany(LocationLike::class);
    }

    /**
     * Get the post keeps for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postKeeps()
    {
        return $this->hasMany(PostKeep::class);
    }
}

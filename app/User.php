<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are guarded
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Hash the password before insert it to database
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get user avatar
     *
     * @return string
     */
    public function avatar()
    {
        return 'https://gravatar.com/avatar/'. md5($this->email) .'?s=45&d=mm';
    }

    /**
     * Collection of user topics
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topic()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * This method will return true only if user owns topic
     *
     * @param Topic $topic
     * @return bool
     */
    public function ownsTopic(Topic $topic)
    {
        return $this->id === $topic->user->id;
    }

    /**
     * This method will return true only if user owns post
     *
     * @param Post $post
     * @return bool
     */
    public function ownsPost(Post $post)
    {
        return $this->id === $post->user->id;
    }

    /**
     * Check if this user liked a specific post or not
     *
     * @param Post $post
     * @return bool
     */
    public function hasLikedPost(Post $post)
    {
        return $post->likes->where('user_id', $this->id)->count() === 1;
    }
}

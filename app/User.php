<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    // Esto no vale pa na
    // protected $primaryKey = 'username';
    // public $incrementing = false;
    // // In Laravel 6.0+ make sure to also set $keyType
    // protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $caca = 'SUPERCACA';


    // 1 to 1 with profile table.
    public function profile() {
        return $this->hasOne('App\Profile'); // Profile migration model has a user_id field to match this
    }

    /**
     * Get all of the user's posts.
     */
    public function posts()
    {
        $return = $this->hasMany('App\Post', 'user_id')->orderBy('created_at', 'DESC');
        
        return $return;
    }

    public function latestPosts($limit)
    {
        $posts = $this->posts();
        return $this->posts()->latest()->take($limit)->get();
    }

    public function postscount() {
        return $this->posts()->count();
    }


    // Follow feature. Many to many
    public function following() {
        return $this->belongsToMany('App\Profile', 'profile_user_pivot', 'followedByUser_id', 'followingProfile_id');
    }

    // placeholder to use in the view
    public function isFollowedByCurrentUser() {
        if (!Auth::check()) return false;

        return auth()->user()->following()->where('profiles.id', $this->profile->id )->exists();
        
    }

}

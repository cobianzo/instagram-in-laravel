<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['image', 'title', 'description', 'url'];
    
    // 1 to 1 with user table. Every User has a profile (so we can consider Profile as a child Model of User)
    public function user() {
        return $this->belongsTo('App\User');
    }

    // Follow feature. Many to many
    public function followedBy() {
        return $this->belongsToMany('App\User', 'profile_user_pivot', 'followingProfile_id', 'followedByUser_id');
    }

}

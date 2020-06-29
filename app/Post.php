<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['caption', 'image'];

    /**
     * Get the owning profile model.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

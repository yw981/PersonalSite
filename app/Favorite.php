<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['title', 'url','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topics(){
        return $this->belongsToMany(Topic::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'bio'];

    protected function favorites(){
        return $this->belongsToMany(Favorite::class);
    }

    protected function articles(){
        return $this->belongsToMany(Article::class);
    }
}

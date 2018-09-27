<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'body','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topics(){
        return $this->belongsToMany(Topic::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_hidden', false);
    }

}

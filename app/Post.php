<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ['user_id', 'title', 'content', 'published', 'published_date'];

    public function scopePublished($query)
    {
    	return $query->where('published', true);
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

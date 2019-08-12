<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = 'posts';

    /**
     * The roles that belong to the user.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}

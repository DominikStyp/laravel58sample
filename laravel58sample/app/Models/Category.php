<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';

    /**
     * The roles that belong to the user.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

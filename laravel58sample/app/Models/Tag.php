<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $table = 'tags';



    public function categories()
    {
        return $this->morphedByMany(Category::class, 'taggable');
    }


}

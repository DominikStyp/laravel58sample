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
        /**
         * NOTICE!!!
         * withTimestamps() will cause auto update timestamp fields
         * in the pivot table on insert/update
         *
         * as('categorization') will cause that you can now reference pivot
         * table as 'categorization' ex:
         * <code>
         * foreach($post->categories as $category){
         *      echo $category->categorization->created_at;
         * }
         * </code>
         */
        return $this->belongsToMany(Post::class)
                    ->as('categorization')
                    ->withTimestamps();
    }

    /**
     * Here we define morphing relationship which means
     * that we can associate tags with many different models,
     * not just one like it is with regular relationship
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

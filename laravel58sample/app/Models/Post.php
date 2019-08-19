<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * Class Post
 * @package App\Models
 *
 * @property string $title
 * @property string $content
 * @property User $users
 *
 */
class Post extends Model
{
    public $table = 'posts';
    public $fillable = ['title', 'content', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
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
        return $this->belongsToMany(Category::class)
            ->as('categorization')
            ->withTimestamps();
    }

    /**
     * Here we define morphing relationship which means
     * that we can associate tags with many different models,
     * not just one like it is with regular relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

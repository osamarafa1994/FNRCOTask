<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;    
use App\Models\Comment;
use App\Models\Like;
use App\Models\Photo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    /**
     * Get all of the likes for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    /**
     * Get the user_like that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_like()
    {
        return $this->belongsTo(Like::class, 'id', 'post_id')->where('user_id',Auth::id());
    }

    /**
     * Get all of the post's Photos.
     */
    public function images()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}

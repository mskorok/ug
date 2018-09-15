<?php

namespace App\Models\Reviews;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReviewComment
 * @package App\Models\Reviews
 */
class ReviewComment extends Model
{


    const VALIDATION_RULES = [
        'text'           => 'string|max:255|required',
        'review_id'      => 'integer|required',
        'user_id'      => 'integer|required'
    ];

    protected $table = 'reviews_comments';

    /**
     * When true - images will be created with all formats;
     * @var boolean
     */
    protected $photoUploads = false;


    protected $fillable = [
        'like_count', 'reply_count', 'text', 'created_at','updated_at', 'review_id', 'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review()
    {
        return $this->belongsTo('App\Models\Reviews\Review', 'review_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Reviews\ReviewComment', 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany('App\Models\Reviews\ReviewComment', 'parent_id', 'id');
    }

    /**
     * @param $userId
     * @return bool
     */
    public function isLiked($userId)
    {
        $liked = json_decode($this->liked);
        return (is_array($liked)) ? in_array((int) $userId, $liked) : false;
    }
}

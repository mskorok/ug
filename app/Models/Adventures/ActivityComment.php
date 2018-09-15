<?php

namespace App\Models\Adventures;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityComment
 * @package App\Models\Adventures
 */
class ActivityComment extends Model
{

    const VALIDATION_RULES = [
        'text'           => 'string|max:255|required',
        'adventure_id'      => 'integer|required',
        'user_id'      => 'integer|required'
    ];

    protected $table = 'activities_comments';

    /**
     * When true - images will be created with all formats;
     * @var boolean
     */
    protected $photoUploads = false;


    protected $fillable = [
        'like_count', 'reply_count', 'text',  'created_at','updated_at', 'adventure_id', 'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adventure()
    {
        return $this->belongsTo('App\Models\Adventures\Adventure', 'adventure_id', 'id');
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
        return $this->belongsTo('App\Models\Adventures\ActivityComment', 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany('App\Models\Adventures\ActivityComment', 'parent_id', 'id');
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

<?php

namespace App\Models\Interests;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Interest
 * @package App\Models\Interests
 */
class Interest extends \Eloquent
{
    const VALIDATION_RULES = [
        'name' => 'required|min:3|max:15'
    ];

    protected $table = 'interests';

    protected $fillable = ['name','created_at','updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\Users\User', 'interest_user');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function adventures()
    {
        return $this->belongsToMany('App\Models\Adventures\Adventure');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews()
    {
        return $this->belongsToMany('App\Models\Reviews\Review');
    }
}

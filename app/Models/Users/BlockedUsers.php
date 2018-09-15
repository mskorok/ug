<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BlockedUsers
 * @package App\Models\Users
 */
class BlockedUsers extends Model
{
    protected $table = 'blocked_users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}

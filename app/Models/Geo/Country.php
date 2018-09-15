<?php

namespace App\Models\Geo;

use App\Models\Traits\Iterable;

/**
 * Class Country
 * @package App\Models\Geo
 */
class Country extends \Eloquent
{
    use Iterable;

    public $timestamps = false;

    protected $fillable = ['iso_alpha2', 'name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany('App\Models\Geo\City');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adventures()
    {
        return $this->hasMany('App\Models\Adventures\Adventure');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Reviews\Review');
    }
}

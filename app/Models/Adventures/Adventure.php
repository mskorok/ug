<?php

namespace App\Models\Adventures;

use App\Models\Interests\Interest;
use App\Models\Traits\Postable;
use App\Services\PhotoUploadService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uploadable;

/**
 * Class Adventure
 * @package App\Models\Adventures
 */
class Adventure extends Model
{
    use Uploadable;

    protected $place_location_lng;

    protected $place_location_lat;



    const VALIDATION_RULES = [
        'place_id' => 'string|max:255|required',
        'is_private' => 'boolean',
        'is_published' => 'boolean',
        'lat' => 'required',
        'lng' => 'required',
        'title' => 'string|max:128|required',
        'slug' => 'string|max:128',
        'place_name' => 'string|max:128|required',
        'short_description' => 'string|max:255|required',
        'datetime_from' => 'date|required',
        'datetime_to'        => 'date|required',
        'category_sid'   => 'required',
        'user_id'           => 'integer|required',
        'place_location'    => 'string|max:255|required'
    ];

    protected $table = 'adventures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',//temporary  todo delete this
        'country_name',
        'place_id',
        'is_private',
        'is_published',
        'comments_count',
        'going',
        'following',
        'promo_image',
        'title',
        'slug',
        'place_name',
        'short_description',
        'description',
        'datetime_from',
        'datetime_to',
        'place_location',
        'created_at',
        'updated_at',
        'category_sid',
        'liked'
    ];

    protected $hidden = ['place_location'];


    protected $file_columns = ['promo_image'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'datetime_from', 'datetime_to'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }


    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->country_name;
    }

    /**
     * @param int $type
     * @return \Carbon\Carbon|\Illuminate\Support\Collection|int|mixed|null|string|static
     */
    public function getPromoImage($type = APP_PHOTO_DEFAULT)
    {
        /** @var PhotoUploadService $photoUploader */
        $photoUploader = app('photoUpload');
        return $photoUploader->getImage($this, $type);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interests()
    {
        return $this->belongsToMany('App\Models\Interests\Interest');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Adventures\ActivityComment');
    }


    /**
     * @param $interests
     * @return Collection|mixed|null|static
     */
    public static function getAdventuresByInterests($interests)
    {
        $adventures = new Collection();
        if ($interests instanceof Collection) {
            $interests = $interests->all();
            /** @var Interest $interest */
            foreach ($interests as $interest) {
                $adventures = $adventures->merge($interest->adventures()->getResults()->all());
            }
            return $adventures;
        } elseif (is_array($interests)) {
            /** @var Interest $interest */
            foreach ($interests as $interest) {
                $adventures = $adventures->merge($interest->adventures()->getResults()->all());
            }
            return $adventures;
        } elseif ($interests instanceof Interest) {
            return $interests->adventures()->getResults();
        } else {
            return null;
        }

    }

    /**
     * get users by interests
     *
     * @return array|static[]
     */
    public function users()
    {
        return \DB::table('users')
            ->join('interest_user', 'users.id', '=', 'interest_user.user_id')
            ->join('adventure_interest', 'adventure_interest.interest_id', '=', 'interest_user.interest_id')
            ->where('adventure_interest.adventure_id', '=', $this->id)
            ->select('users.*')
            ->distinct()
            ->get();
    }


    /**
     * @return array
     */
    public function getLocationAttribute()
    {
        return [
            'lat' => $this->attributes['place_location_lat'],
            'lng' => $this->attributes['place_location_lng']
        ];

    }


    /**
     * @param $value
     * @throws \Exception
     */
    public function setLocationAttribute($value)
    {
        if (!isset($value['lat']) && !isset($value['lng'])) {
            throw new \Exception(
                'New value of Adventure::place_location must be an array with keys "lat" and "lng"'
            );
        }

        $this->attributes['place_location'] = DB::raw('POINT(' . $value['lat'] . ', ' . $value['lng'] . ')');

        $this->place_location_lat = $value['lat'];

        $this->place_location_lng = $value['lng'];
    }


    /**
     * @return mixed
     */
    public function newQuery()
    {

        return parent::newQuery()->selectRaw(
            '*, ST_X(place_location) AS place_location_lat, ST_Y(place_location) AS place_location_lng'
        );
    }

    /**
     * @return Adventure|Collection|mixed|null
     */
    public function related()
    {
        $interests = $this->interests()->getResults();
        $collection = static::getAdventuresByInterests($interests);
        $collection = $collection->diff([$this]);
        return $collection;
    }

    /**
     * @return mixed
     */
    public function getGoingAttribute()
    {
        return json_decode($this->attributes['going']);
    }

    /**
     * @param array $value
     * @throws Exception
     */
    public function setGoingAttribute(array $value)
    {
        foreach ($value as $item) {
            if (!is_id($item)) {
                throw new Exception('Adventure::going must be an array of unsigned integers >= 1');
            }
        }
        $this->attributes['going'] = json_encode($value);
    }

    /**
     * @return int
     */
    public function getGoingCount()
    {
        return count($this->going);
    }

    /**
     * @return mixed
     */
    public function getFollowingAttribute()
    {
        return json_decode($this->attributes['following']);
    }

    /**
     * @param array $value
     */
    public function setFollowingAttribute(array $value)
    {
        $this->attributes['following'] = json_encode($value);
    }

    /**
     * @return int
     */
    public function getFollowingCount()
    {
        return count($this->following);
    }

    /**
     * @param array $value
     */
    public function setLikedAttribute(array $value)
    {
        $this->attributes['liked'] = json_encode($value);
    }

    /**
     * @return int
     */
    public function getCommentsCount()
    {
        return $this->attributes['comments_count'];
    }

    /**
     * @return mixed
     */
    public function getDescriptionAttribute()
    {
        return br2p($this->attributes['description']);
    }

    /**
     * @param $userId
     * @return bool
     */
    public function isLiked($userId)
    {
        $liked = json_decode($this->attributes['liked']);
        return (is_array($liked)) ? in_array((int) $userId, $liked) : false;
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getStatsGoingAttribute()
    {
        if ($this->getGoingCount() > 0) {
            return trans('core.participating_count', ['count' => $this->getGoingCount()]);
        }
        return '';
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getStatsFollowingAttribute()
    {
        if ($this->getFollowingCount() > 0) {
            return trans('core.following_count', ['count' => $this->getFollowingCount()]);
        }
        return '';
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getStatsCommentsAttribute()
    {
        if ($this->getCommentsCount() > 0) {
            return trans('core.comments_count', ['count' => $this->getCommentsCount()]);
        }
        return '';
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getStatsAddedAgoAttribute()
    {
        return trans('core.added_ago', ['time' => $this->created_at->diffForHumans()]);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return '/activities/' . $this->slug . '-' . $this->id;
    }

    /**
     * @return array
     */
    public function getFileColumns()
    {
        return $this->file_columns;
    }
}

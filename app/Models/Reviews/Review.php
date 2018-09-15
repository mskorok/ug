<?php

namespace App\Models\Reviews;

use App\Models\Adventures\Adventure;
use App\Models\Interests\Interest;
use App\Models\Traits\Uploadable;
use App\Models\Users\User;
use App\Services\PhotoUploadService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * @package App\Models\Reviews
 */
class Review extends Model
{

    use Uploadable;

    public $relatedPerPage = 2;

    protected $place_location_lng;

    protected $place_location_lat;

    const VALIDATION_RULES = [
        'place_id'          => 'string|max:255',
        'lat'               => 'required',
        'lng'               => 'required',
        'title'             => 'string|max:128|required',
        'slug'              => 'string|max:128',
        'place_name'        => 'string|max:128|required',
        'short_description' => 'string|max:255|required',
        'datetime_from'     => 'date|required',
        'category_sid'   => 'required',
        'user_id'           => 'integer|required',
    ];

    protected $table = 'reviews';

    protected $fillable = [
        'user_id',//temporary  todo delete this
        'country_name',
        'place_id',
        'comments_count',
        'recommend_count',
        'promo_image',
        'gallery',
        'liked',
        'recommended',
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
        'category_sid'
    ];

    protected $hidden = ['place_location'];


    protected $file_columns = ['promo_image'];

    protected $gallery_columns = ['gallery'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }


    /**
     * @return Carbon|\Illuminate\Support\Collection|int|mixed|static
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
        return $this->hasMany('App\Models\Reviews\ReviewComment');
    }

    /**
     * @param $interests
     * @return Collection|mixed|null|static
     */
    public static function getReviewsByInterests($interests)
    {
        $reviews = new Collection();
        if ($interests instanceof Collection) {
            $interests = $interests->all();
            /** @var Interest $interest */
            foreach ($interests as $interest) {
                $reviews = $reviews->merge($interest->reviews()->getResults()->all());
            }
            return $reviews;
        } elseif (is_array($interests)) {
            /** @var Interest $interest */
            foreach ($interests as $interest) {
                $reviews = $reviews->merge($interest->reviews()->getResults()->all());
            }
            return $reviews;
        } elseif ($interests instanceof Interest) {
            return $interests->reviews()->getResults();
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
            ->join('review_interest', 'review_interest.interest_id', '=', 'interest_user.interest_id')
            ->where('review_interest.review_id', '=', $this->id)
            ->select('users.*')
            ->distinct()
            ->get();
    }

    /**
     * @param null $limit
     * @return Collection
     */
    public function getMatchedUsers($limit = null)
    {
        $interestIds = $this->getInterestIds();
        $modelInterests = $this->interests()->get();
        $array = [];
        /** @var Collection $collection */
        $collection = User::whereHas('interests', function ($query) use ($interestIds) {
            $query->whereIn('id', $interestIds);
        })->get()->unique();
        $collection = $collection->diff([$this->user]);
        /** @var User $item */
        foreach ($collection as $user) {
            $interests = $user->interests()->get();
            $array[] = [
                'count' => (int) $interests->intersect($modelInterests)->count(),
                'user' => $user
            ];
        }
        $array = $this->sort($array);
        if ($limit && is_numeric($limit)) {
            $array = array_slice($array, 0, (int) $limit);
        }
        return $array;
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
                'New value of Review::place_location must be an array with keys "lat" and "lng"'
            );
        }

        $this->attributes['place_location'] = \DB::raw('POINT(' . $value['lat'] . ', ' . $value['lng'] . ')');

        $this->place_location_lat = $value['lat'];

        $this->place_location_lng = $value['lng'];

    }

    /**
     * @return mixed
     */
    public function getDescriptionAttribute()
    {
        return br2p($this->attributes['description']);
    }



    public function setZeroGalleryAttribute()
    {
        $this->attributes['gallery'] = json_encode([]);
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
     * @return Review|Collection|mixed|null
     */
    public function related()
    {
        $interests = $this->interests()->getResults();
        $collection = static::getReviewsByInterests($interests);
        $collection = $collection->diff([$this]);
        return $collection;
    }

    /**
     * @return Collection|mixed|null|static
     */
    public function relatedActivities()
    {
        $interests = $this->interests()->getResults();
        return Adventure::getAdventuresByInterests($interests);
    }

    /**
     * @return mixed|null
     */
    public function recommendedReviews()
    {
        $related = $this->related();
        $max = 0;
        $result = null;
        /** @var $this $item */
        foreach ($related as $item) {
            if ($max < $item->recommend_count) {
                $max = $item->recommend_count;
                $result = $item;
            }
        }
        return $result;
    }

    /**
     * @return int
     */
    public function getCommentsCount()
    {
        return $this->attributes['comments_count'];
    }

    /**
     * @return string
     */
    public function lastRead()
    {
        return '5 min read';
    }

    /**
     * @param array $value
     */
    public function setRecommendedAttribute(array $value)
    {
        $this->attributes['recommended'] = json_encode($value);
    }



    /**
     * @param array $value
     */
    public function setLikedAttribute(array $value)
    {
        $this->attributes['liked'] = json_encode($value);
    }



    /**
     * @param $userId
     * @return bool
     */
    public function isLiked($userId)
    {
        $liked = json_decode($this->attributes['liked']);
        return (is_array($liked)) ? in_array((int)$userId, $liked) : false;
    }


    /**
     * @param $userId
     * @return bool
     */
    public function isRecommended($userId)
    {
        $recommended = json_decode($this->attributes['recommended']);
        return (is_array($recommended)) ? in_array((int)$userId, $recommended) : false;
    }

    /******************************* PROTECTED ****************************************/

    /**
     * @return array
     */
    protected function getInterestIds()
    {
        $collection = $this->interests()->get(['id']);
        $ids = [];

        foreach ($collection as $item) {
            $ids[] = $item->id;
        }
        return $ids;
    }

    /**
     * @return Carbon|\Illuminate\Support\Collection|int|mixed|static
     */
    public function getLikesCount()
    {
        return $this->attributes['like_count'];
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getStatsLikesAttribute()
    {
        return trans('core.likes_count', ['count' => $this->getLikesCount()]);
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getStatsCommentsAttribute()
    {
        return trans('core.comments_count', ['count' => $this->getCommentsCount()]);
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getStatsReadTimeAttribute()
    {
        $word_count = str_word_count($this->description);
        $words_per_min = 180;
        $read_time = ceil($word_count / $words_per_min);
        return trans('core.read_time', ['time' => $read_time]);
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
        return '/reviews/' . $this->slug . '-' . $this->id;
    }
    
    /**
     * @param $array
     * @return mixed
     */
    protected function sort($array)
    {
        usort($array, function ($a, $b) {
            if ($a['count'] == $b['count']) {
                return 0;
            }
            return ($a['count'] < $b['count']) ? 1 : -1;
        });

        return $array;
    }

    /**
     * @return array
     */
    public function getFileColumns()
    {
        return $this->file_columns;
    }

    /**
     * @return array
     */
    public function getGalleryColumns()
    {
        return $this->gallery_columns;
    }
}

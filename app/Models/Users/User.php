<?php

namespace App\Models\Users;

use App\Enumerations\SocialProviders;


use App\Models\Adventures\Adventure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Interests\Interest;
use App\Models\Traits\Uploadable;
use App\Services\PhotoUploadService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Exception;
use Illuminate\Support\Facades\App;

/**
 * Class User
 * @package App\Models\Users
 */
class User extends Authenticatable
{
    use Uploadable;

    const VALIDATION_RULES = [
        'name'       => 'required|string|min:1|max:50',
        'birth_date' => 'date',
        'gender_sid' => 'integer|min:1|max:2',
        'categories.*' => 'integer|min:1',
        'interests.*' => 'integer|min:1',
        'hometown_id' => 'required|string',
        'geo_service' => 'required|string',
        'about' => 'string|max:140',
        'work' => 'string|max:140'
    ];

    protected $attributes = ['profile_show_age' => 1];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_show_age',
        'gender_sid',
        'categories_bit',
        'email_notifications_bit',
        'alert_notifications_bit',
        'profile_locale',
        'name',
        'email',
        'adventurer_title',
        'password',
        'about',
        'work',
        'birth_date',
        'geo_service',
        'hometown_location',
        'hometown_id',

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'birth_date'];



    /*public function __construct(array $attributes = [])
    {
        $this->setPhotoUploads(true);
        parent::__construct($attributes);
    }*/

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_code', 'hometown_location',
    ];

    protected $file_columns = ['photo_path'];

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = empty($value) ? '' : bcrypt($value);
    }

    /**
     * @param $value
     */
    public function setProfileLocaleAttribute($value)
    {
        $this->attributes['profile_locale'] = \App::checkAndGetLocale($value ?? null);
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
    public function oauths()
    {
        return $this->hasMany('App\Models\Users\UserOauth');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blockedUsers()
    {
        return $this->hasMany('App\Models\Users\BlockedUsers');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interests()
    {
        return $this->belongsToMany('App\Models\Interests\Interest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany('App\Models\Geo\Language', 'users_languages');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activityComments()
    {
        return $this->hasMany('App\Models\Adventures\ActivityComment');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewComments()
    {
        return $this->hasMany('App\Models\Reviews\ReviewComment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Reviews\Review');
    }

    /**
     * @param $value
     * @return array
     */
    public function getCategoriesBitAttribute($value)
    {
        return int_bitmask_to_id_array($value);
    }

    /**
     * @param array $value
     */
    public function setCategoriesBitAttribute(array $value)
    {
        $this->attributes['categories_bit'] = id_array_to_int_bitmask($value);
    }

    /**
     * @param $value
     * @return array
     */
    public function getEmailNotificationsBitAttribute($value)
    {
        return int_bitmask_to_id_array($value);
    }

    /**
     * @param array $value
     */
    public function setEmailNotificationsBitAttribute(array $value)
    {
        $this->attributes['email_notifications_bit'] = id_array_to_int_bitmask($value);
    }

    /**
     * @param $value
     * @return array
     */
    public function getAlertNotificationsBitAttribute($value)
    {
        return int_bitmask_to_id_array($value);
    }

    /**
     * @param array $value
     */
    public function setAlertNotificationsBitAttribute(array $value)
    {
        $this->attributes['alert_notifications_bit'] = id_array_to_int_bitmask($value);
    }

    /**
     * @return array
     */
    public function getMatchedUsers()
    {
        $collection = $this->interests()->get();

        $matched = $this->getMatchedByInterests();
        $res = [];
        /** @var User $item */
        foreach ($matched as $item) {
            $interests = $item->interests()->get();
            if ($interests->count() > 0) {
                $intersect = $interests->intersect($collection);
                $count = $intersect->count();
                if ($count > 0) {
                    $res[] = [
                        'id' => $item->id,
                        'user' => $item,
                        'interests' => $intersect,
                        'count' => $count
                    ];
                }
            }
        }

        usort($res, function ($a, $b) {
            if ($a['count'] == $b['count']) {
                return 0;
            }
            return ($a['count'] < $b['count']) ? 1 : -1;
        });

        return $res;

    }


    /**
     * @param $user
     * @return array
     */
    public static function matched($user)
    {
        $id = ($user instanceof User) ? $user->id : $user;

        $sql = "SELECT u.id , iu1.user_id, u1.name, u1.photo_path, COUNT(*) AS 'count'
                FROM users u
                    JOIN interest_user iu
                        ON iu.user_id = u.id
                    JOIN interests i
                        ON i.id = iu.interest_id
                    JOIN interest_user iu1
                        ON iu1.interest_id = i.id AND iu1.user_id <> u.id
                    JOIN users u1
                        ON u1.id = iu1.user_id
                WHERE u.id = :id
                GROUP BY u.id, iu1.user_id
                ORDER BY u.id, COUNT(*) DESC LIMIT 7;";

        return \DB::select($sql, [$id]);
    }

    /**
     * @return array|static[]
     */
    public function advents()
    {
        return \DB::table('adventures')
            ->join('adventure_interest', 'adventures.id', '=', 'adventure_interest.adventure_id')
            ->join('interest_user', 'interest_user.interest_id', '=', 'adventure_interest.interest_id')
            ->where('interest_user.user_id', '=', $this->id)
            ->select('adventures.*')
            ->distinct()
            ->get();
    }

    /**
     * @param $interests
     * @return Collection|mixed|null|static
     */
    public static function getUsersByInterests($interests)
    {
        $users = new Collection();
        if ($interests instanceof Collection) {
            $interests = $interests->all();
            /** @var Interest $interest */
            foreach ($interests as $interest) {
                $users = $users->merge($interest->users()->getResults()->all());
            }
            return $users;
        } elseif (is_array($interests)) {
            /** @var Interest $interest */
            foreach ($interests as $interest) {
                $users = $users->merge($interest->users()->getResults()->all());
            }
            return $users;
        } elseif ($interests instanceof Interest) {
            return $interests->users()->getResults();
        } else {
            return null;
        }

    }

    /**
     * Saves social id for a specified user/provider
     *
     * @param string $provider
     * @param int|string $socialId
     * @param int $userId
     * @throws Exception
     */
    public static function saveSocialId(string $provider, string $socialId, int $userId)
    {
        $providerId = SocialProviders::getId($provider);

        if (!$userId) {
            throw new Exception('User must be saved to db before adding Facebook id.');
        } else {
            $result = DB::table('users_oauths')
                ->select(['oauth_id'])
                ->where('user_id', $userId)
                ->where('oauth_provider', $providerId)->count();

            if (empty($result)) {
                DB::table('users_oauths')->insert(
                    ['user_id' => $userId, 'oauth_provider' => $providerId, 'oauth_id' => $socialId]
                );
            } elseif ($result['oauth_id'] != $providerId) {
                DB::table('users_oauths')
                    ->where('user_id', $userId)
                    ->where('oauth_provider', $providerId)
                    ->update(['oauth_id' => $socialId]);
            }
        }
    }

    /**
     * @return mixed|string
     */
    public function getPhotoPathAttribute()
    {
        return empty($this->attributes['photo_path']) ?
            config('_project.no_avatar_image_path') : $this->attributes['photo_path'];
    }

    /**
     * @return string
     */
    public function getProfileUrl()
    {
        return '/users/' . $this->id;
    }

    /**
     * @param bool $use_profile_settins = true
     * @return int|bool - years or false if user disabled showing age in profile settings
     */
    public function getAge($use_profile_settins = true)
    {
        if ($use_profile_settins) {
            if ($this->profile_show_age) {
                //return get_years_since_date($this->birth_date);
                return $this->birth_date->age;
            } else {
                return false;
            }
        } else {
            //return get_years_since_date($this->birth_date);
            return $this->birth_date->age;
        }
    }

    /**
     * @return bool
     */
    public function getFacebookUserId()
    {
        return $this->getSocialId(APP_OAUTH_PROVIDER_FACEBOOK);
    }

    /**
     * @return bool
     */
    public function getGoogleUserId()
    {
        return $this->getSocialId(APP_OAUTH_PROVIDER_GOOGLE);
    }

    /**
     * @param $activationCode
     * @return mixed|static
     */
    public static function getPendingActivation($activationCode)
    {

        return $user = DB::table('users')
            ->where('activation_code', $activationCode)
            ->whereNull('activated_at')
            ->first();
    }

    /**
     * @param $id
     */
    public static function activate($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(['activated_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * @param int $size
     * @return string
     */
    public static function generateActivationCode($size = 20)
    {
        return hash_hmac('sha256', str_random($size), config('app.key'));
    }

    /**
     *
     */
    public function setActivationCode()
    {
        $this->attributes['activation_code'] = self::generateActivationCode();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getHometown()
    {
        return $this->hometown_name;
    }

    /**
     * @param $value
     * @throws \Exception
     */
    public function setHometownLocationAttribute($value)
    {
        if (!isset($value['lat']) && !isset($value['lng'])) {
            throw new \Exception(
                'New value of hometown location must be an array with keys "lat" and "lng"'
            );
        }

        $this->attributes['hometown_location'] = DB::raw('POINT(' . $value['lat'] . ', ' . $value['lng'] . ')');
    }

    /**
     * @param array $data
     * @return User
     * @throws Exception
     */
    public static function createWithRelatedEntities(array $data)
    {
        if (isset($data['id'])) {
            throw new Exception('ID must not be specified. It is generated automatically on creation');
        }

        return self::updateOrCreate($data);
    }

    /**
     * @param array $data
     * @return User
     * @throws Exception
     */
    public static function updateWithRelatedEntities(array $data)
    {
        if (empty($data['id'])) {
            throw new Exception('ID must be specified');
        }

        return self::updateOrCreate($data);
    }



    public function unlinkFacebookAccount()
    {
        $this->unlinkSocialAccount(APP_OAUTH_PROVIDER_FACEBOOK);
    }

    public function unlinkGoogleAccount()
    {
        $this->unlinkSocialAccount(APP_OAUTH_PROVIDER_GOOGLE);
    }

    /**
     * @return array
     */
    public function getNotSelectedCategories()
    {
        $userCategories = array_flip($this->categories_bit);
        $categories = trans('models/categories');

        return array_diff_key($categories, $userCategories);
    }

    /**
     * @param int $type
     * @return mixed|string
     * @throws Exception
     */
    public function getPhotoPath($type = APP_PHOTO_DEFAULT)
    {
        /** @var PhotoUploadService $photoUploader */
        $photoUploader = app('photoUpload');
        return $photoUploader->getImage($this, $type);
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getCommonFriendsCount()
    {
        if (!Auth::check()) {
            throw new Exception('User must be logged in to use User::getCommonFriendsCount()');
        }
        $user = Auth::user();
        if ($user->id === $this->id) {
            throw new Exception('Can not call User::getCommonFriendsCount() on same user');
        }
        return mt_rand(0, 5);
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getCommonInterestsCount()
    {
        if (!Auth::check()) {
            throw new Exception('User must be logged in to use User::getCommonInterestsCount()');
        }
        $user = Auth::user();
        if ($user->id === $this->id) {
            throw new Exception('Can not call User::getCommonInterestsCount() on same user');
        }
        return count(DB::select(
            'SELECT interest_id FROM interest_user 
            WHERE user_id IN (?, ?) 
            GROUP BY interest_id 
            HAVING COUNT(1) > 1',
            [$user->id, $this->id]
        ));
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     * @throws Exception
     */
    public function getStatsCommonFriendsCountAttribute()
    {
        $c = $this->getCommonFriendsCount();
        if ($c > 0) {
            return trans('core.common_friends_count', ['count' => $c]);
        }
        return '';
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     * @throws Exception
     */
    public function getStatsCommonInterestsCountAttribute()
    {
        $c = $this->getCommonInterestsCount();
        if ($c > 0) {
            return trans('core.common_interests_count', ['count' => $c]);
        }
        return '';
    }

    /**
     * Returns query for people/new page
     * @param int $user_id
     * @param array $categories
     * @return Builder
     */
    public static function getPeopleNewQ(int $user_id, array $categories) : Builder
    {
        $fields = [
            'u1.id',
            'u1.name',
            'u1.photo_path',
            'u1.categories_bit',
            'u1.created_at',
            'iu1.user_id'
        ];

        $query = DB::table('users as u')
            ->select($fields)
            ->addSelect(DB::raw('COUNT(*) as common_interest_count'))
            ->addSelect(DB::raw('FLOOR(RAND() * 5) as common_likes'))
            ->join('interest_user as iu', 'iu.user_id', '=', 'u.id')
            ->leftJoin('interest_user as iu1', 'iu1.interest_id', '=', 'iu.interest_id')
            ->leftJoin('users as u1', 'u1.id', '=', 'iu1.user_id')
            ->where('u.id', Auth::user()->id)
            ->where('iu1.user_id', '<>', 'u.id')
            ->groupBy($fields);

        $rawCondition = '';

        foreach ($categories as $id => $category) {
            if ($category['checked']) {
                if ($id == 1) {
                    $rawCondition .= ' OR categories_bit & 1';
                } else {
                    $rawCondition .= ' OR (categories_bit >> ' . ($id - 1) . ') & 1';
                }
            }
        }

        if (! empty($rawCondition)) {
            $rawCondition = substr($rawCondition, 4);
            $query->whereRaw("($rawCondition)");
        }

        return $query;
    }

    /**
     * Returns query for people/popular page
     * @param int $user_id
     * @param array $categories
     * @return Builder
     */
    public static function getPeoplePopularQ(int $user_id, array $categories) : Builder
    {
        $fields = [
            'u1.id',
            'u1.name',
            'u1.photo_path',
            'u1.categories_bit',
            'u1.created_at',
            'iu1.user_id'
        ];

        $query = DB::table('users as u')
            ->select($fields)
            ->addSelect(DB::raw('COUNT(*) as common_interest_count'))
            ->addSelect(DB::raw('FLOOR(RAND() * 5) as common_likes'))
            ->addSelect(DB::raw('FLOOR(RAND() * 500) as rand'))
            ->join('interest_user as iu', 'iu.user_id', '=', 'u.id')
            ->leftJoin('interest_user as iu1', 'iu1.interest_id', '=', 'iu.interest_id')
            ->leftJoin('users as u1', 'u1.id', '=', 'iu1.user_id')
            ->where('u.id', Auth::user()->id)
            ->where('iu1.user_id', '<>', 'u.id')
            ->groupBy($fields)
            ->orderBy('rand');

        $rawCondition = '';

        foreach ($categories as $id => $category) {
            if ($category['checked']) {
                if ($id == 1) {
                    $rawCondition .= ' OR categories_bit & 1';
                } else {
                    $rawCondition .= ' OR (categories_bit >> ' . ($id - 1) . ') & 1';
                }
            }
        }

        if (! empty($rawCondition)) {
            $rawCondition = substr($rawCondition, 4);
            $query->whereRaw("($rawCondition)");
        }

        return $query;
    }

    /**
     * Returns query for people/popular page
     * @param int $user_id
     * @param array $categories
     * @return Builder
     */
    public static function getPeopleFriendsQ(int $user_id, array $categories) : Builder
    {
        $fields = [
            'u1.id',
            'u1.name',
            'u1.photo_path',
            'u1.categories_bit',
            'u1.created_at',
            'iu1.user_id'
        ];

        $query = DB::table('users as u')
            ->select($fields)
            ->addSelect(DB::raw('COUNT(*) as common_interest_count'))
            ->addSelect(DB::raw('FLOOR(RAND() * 5) as common_likes'))
            ->join('interest_user as iu', 'iu.user_id', '=', 'u.id')
            ->leftJoin('interest_user as iu1', 'iu1.interest_id', '=', 'iu.interest_id')
            ->leftJoin('users as u1', 'u1.id', '=', 'iu1.user_id')
            ->where('u.id', Auth::user()->id)
            ->where('iu1.user_id', '<>', 'u.id')
            ->groupBy($fields);

        $rawCondition = '';

        foreach ($categories as $id => $category) {
            if ($category['checked']) {
                if ($id == 1) {
                    $rawCondition .= ' OR categories_bit & 1';
                } else {
                    $rawCondition .= ' OR (categories_bit >> ' . ($id - 1) . ') & 1';
                }
            }
        }

        if (! empty($rawCondition)) {
            $rawCondition = substr($rawCondition, 4);
            $query->whereRaw("($rawCondition)");
        }

        return $query;
    }

    /**
     * Returns query, which retrieves friends
     * @param int $user_id
     * @return Builder
     */
    public function getFriendsQ() : Builder
    {
        $userId = Auth::user()->id;

        $fields = [
            'u1.id',
            'u1.name',
            'u1.photo_path',
            'u1.categories_bit',
            'u1.created_at',
            'iu1.user_id'
        ];

        return DB::table('users as u')
            ->select($fields)
            ->addSelect(DB::raw('COUNT(*) as common_interest_count'))
            ->addSelect(DB::raw('FLOOR(RAND() * 5) as common_likes'))
            ->addSelect(DB::raw('FLOOR(RAND() * 500) as rand'))
            ->join('interest_user as iu', 'iu.user_id', '=', 'u.id')
            ->join('interest_user as iu1', 'iu1.interest_id', '=', 'iu.interest_id', 'left outer')
            ->join('users as u1', 'u1.id', '=', 'iu1.user_id', 'left outer')
            ->where('u.id', '<>', $userId)
            ->groupBy($fields)
            ->orderBy('rand');
    }


    /**
     * @return array
     */
    public function getFileColumns()
    {
        return $this->file_columns;
    }

    /**
     * @return mixed
     */
    public function getProfileAdventuresQ()
    {
        return Adventure::query()
            ->whereRaw("JSON_CONTAINS(following, '" . $this->id . "')")
            ->orWhere('user_id', $this->id);

    }

    /*******************************  PROTECTED  **************************/

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
     * @return Collection
     */
    protected function getMatchedByInterests()
    {
        $interestIds = $this->getInterestIds();
        /** @var Collection $collection */
        $collection = User::whereHas('interests', function ($query) use ($interestIds) {
            $query->whereIn('id', $interestIds);
        })->get()->unique();
        $collection = $collection->diff([$this]);

        return $collection;
    }

    /**
     * @param $providerId
     */
    private function unlinkSocialAccount($providerId)
    {
        $this->oauths()->getQuery()->where('oauth_provider', $providerId)->delete();
    }

    /**
     * If id set updates user otherwise creates a new
     * @param array $data
     * @return User
     * @throws Exception
     */
    private static function updateOrCreate(array $data)
    {
        try {
            if (empty($data['id'])) {
                $data['hometown_location'] = ['lat' => $data['hometown_lat'], 'lng' => $data['hometown_lng']];
                $uploader = empty($data['photo_path']) ? false : true;
                $user = new User($data);
                $user->setPhotoUploads($uploader);
                $user->setActivationCode();
                $user->save();
            } else {
                $user = self::find($data['id']);
                $user->name = $data['name'];
                $user->hometown_location = ['lat' => $data['hometown_lat'], 'lng' => $data['hometown_lng']];
                $user->hometown_id = $data['hometown_id'];

                $user->categories_bit = $data['categories_bit'];
                $user->email_notifications_bit =
                    isset($data['email_notifications_bit'])
                        ? $data['email_notifications_bit'] : $user->email_notifications_bit;
                $user->alert_notifications_bit =
                    isset($data['alert_notifications_bit'])
                        ? $data['alert_notifications_bit'] : $user->alert_notifications_bit;
                $user->birth_date = $data['birth_date'];
                $user->email = $data['email'];
                $user->about = $data['about'];
                $user->id = $data['id'];
                $user->geo_service = $data['geo_service'];
                $user->setPhotoUploads(true);
                $user->work = $data['work'];
                $user->profile_show_age = !(isset($data['dont_show_age']) ? $data['dont_show_age'] : 0);
                $user->photo_path = $data['photo_path'];

                $user->save();
            }

            // Re-create user interest links
            $user->interests()->detach();
            $rest = 15;
            // Assign existing interests
            if (isset($data['interest_list'])) {
                $data['interest_list'] = array_unique($data['interest_list']);
                if (count($data['interest_list']) > 15) {
                    $data['interest_list'] = array_slice($data['interest_list'], 0, 15);
                    $rest -= count($data['interest_list']);
                }
                $user->interests()->saveMany(Interest::whereIn('id', $data['interest_list'])->get());
            }


            // Create and assign new interests
            if (isset($data['new_interest_list'])) {
                $data['new_interest_list'] = array_unique($data['new_interest_list']);
                $data['new_interest_list'] = array_slice($data['new_interest_list'], 0, $rest);
                foreach ($data['new_interest_list'] as $interest) {
                    if (strlen((string) $interest) > 3) {
                        $interestModels[] = new Interest(['name' => $interest]);
                        $user->interests()->saveMany($interestModels);
                    }
                }
            }

            // Re-create user language links
            $user->languages()->detach();
            // Set Languages
            if (isset($data['language_list'])) {
                $user->languages()->saveMany(Interest::whereIn('id', $data['language_list'])->get());
            }

            if (!empty($data['social_id'])) {
                $user->saveSocialId($data['social_provider'], $data['social_id'], $user->id);
            }

            return $user;
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * @param $providerId
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    private function getSocialId($providerId)
    {
        $result = $this->oauths()->getQuery()->where('oauth_provider', $providerId)->first(['oauth_id']);

        return isset($result['oauth_id']) ? $result['oauth_id'] : false;
    }

    /**
     * Returns URL to publice profile
     * @return string
     */
    public function getPublicProfileUrl()
    {
        return url('/') . '/users/' . $this->id;
    }
}

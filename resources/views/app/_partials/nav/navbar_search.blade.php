
<?php
use App\Models\Adventures\Adventure;
use App\Models\Reviews\Review;
use App\Models\Users\User;

$search_activities = Adventure::orderByRaw('RAND()')->take(3)->get();
$search_reviews = Review::orderByRaw('RAND()')->take(3)->get();
?>

<div id="navbar_search" class="app-navbar-search dropdown" data-close-inside>
    <svg width="22" height="22" class="app-absolute-right-block m-r-2">
        <use xlink:href="#svg__search_v2" fill="#BBB"></use>
    </svg>

    <input type="search" name="search" data-toggle="dropdown" class="form-control" id="navbar_search_input" placeholder="@lang('core.search_placeholder')" autocomplete="off">

    <div class="dropdown-menu app-navbar-search-menu">

        {{-- Activities --}}
        <div class="dropdown-item-title">
            <div class="app-navbar-search-title">
                @lang('core.activities')
            </div>
        </div>

        @foreach($search_activities as $activity)
        <a role="button" class="dropdown-item">
            <div class="app-navbar-search-img">
                <img src="{{ $activity->promo_image }}" width="80" height="50">
            </div>
            <div class="app-inline-block">
                <div class="app-navbar-search-item-title">{{ $activity->title }}</div>
                <div class="app-navbar-search-item-desc">
                    <div class="app-navbar-search-item-desc-head app-comma-list-dash">
                        <span>{{ $activity->place_name . ', ' . $activity->getCountryName() }}</span>
                        <span>{{ get_future_date_for_humans($activity->datetime_from) }}</span>
                    </div>
                    <div class="app-navbar-search-item-desc-stats app-comma-list-bullet">
                        <span>{{ $activity->statsGoing }}</span>
                        <span>{{ $activity->statsFollowing }}</span>
                        <span>{{ $activity->statsComments }}</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach



        <div class="dropdown-item-title">
            <div class="app-navbar-search-title">
                @lang('core.reviews')
            </div>
        </div>

        @foreach($search_reviews as $review)
            <a role="button" class="dropdown-item">
                <div class="app-navbar-search-item-title">{{ $review->title }}</div>
                <div class="app-navbar-search-item-desc app-comma-list-dash">
                    <span class="app-navbar-search-item-desc-head app-comma-list-dash">
                        <span>{{ $review->statsAddedAgo }}</span>
                        <span>{{ $review->statsReadTime }}</span>
                    </span>
                    <span class="app-navbar-search-item-desc-stats app-comma-list-bullet">
                        <span>{{ $review->statsLikes }}</span>
                        <span>{{ $review->statsComments }}</span>
                    </span>
                </div>
            </a>
        @endforeach



        <div class="dropdown-item-title">
            <div class="app-navbar-search-title">
                @lang('core.people')
            </div>
        </div>

        @if (!Auth::check())

            <div class="dropdown-item-title">
                @lang('core.search_please_login', ['login' => '<a href="' . url('/login') . '">' . trans('core.search_please_login_link') . '</a>'])
            </div>


        @else

            <?php $search_users = User::where('id', '!=', Auth::user()->id)->orderByRaw('RAND()')->take(3)->get(); ?>

            @foreach($search_users as $user)
                <a role="button" class="dropdown-item">
                    <img class="app-navbar-search-img app-circle" src="{{ $user->photo_path }}" width="40" height="40">
                    <div class="app-inline-block">
                        <div class="app-navbar-search-item-title">{{ $user->getName() }}</div>
                        <div class="app-navbar-search-item-desc">
                            <div class="app-navbar-search-item-desc-stats app-comma-list-bullet">
                                <span>{{ $user->statsCommonFriendsCount }}</span>
                                <span>{{ $user->statsCommonInterestsCount }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

        @endif

        <div class="dropdown-item-title">
            <div class="app-navbar-search-title"></div>
        </div>

        <a role="button" class="dropdown-item">
            <svg width="16" height="16" style="margin-right: 10px">
                <use xlink:href="#svg__search_v2" fill="#BBB"></use>
            </svg>
            <span class="app-color-grey">@lang('core.search_view_all')</span>
        </a>

    </div>
</div>

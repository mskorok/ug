<div class="col-md-12 col-xl-6 col-xxl-4 col-xxxl-3 m-b-2 app-inline-block">
    <div class="m-b-1 app-profile-photo app-circle app-square-lg app-inline-block">
        <a href="{{ '/users/' . $user->id }}"><img alt="Profile photo" id="profile_photo" class="app-profile-blocked-user-photo app-relative app-square-xl" src="{{ $user->photo_path }}"></a>
    </div>

    <div class="app-inline-block m-l-2">
                        <span class="app-people-plus-container app-text-sm app-circle app-inline-block">
                            &#x2795
                        </span>
        <span class="app-text-sm app-color-grey">{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</span>
        <a href="{{ '/users/' . $user->id }}" class="app-text-xl app-block app-people-name">{{ $user->name }}</a>
        <div class="app-text-xs app-color-grey">{{ $user->common_interest_count }} common interests</div>
        <div class="app-text-xs app-color-grey">{{ $user->common_likes }} common likes</div>
    </div>

</div>
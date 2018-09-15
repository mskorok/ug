<div class="row">
    <div class="col-xs-12 col-md-6 col-xl-8 col-xxl-9 col-xxxl-10 app-card-b-shadow p-b-2 p-t-2">
        @for($i=0; ($i<6 && $i < count($users)); $i++)
            @include('app._partials.person', ['user' => $users[$i]])
        @endfor
    </div>

    <div class="col-xs-12 col-md-6 col-xl-4 col-xxl-3 col-xxxl-2 m-l-4 app-profile-advertisement">
        <img src="http://placehold.it/640x640">
    </div>

</div>

@if(count($users) >= 7)
    <div class="row">
        <div class="col-xs-12 col-md-6 col-xl-8 col-xxl-9 col-xxxl-10 app-inline-block app-card-b-shadow p-t-2 p-b-2 p-l-1">

            <div class="app-profile-photo app-circle app-square-xl app-inline-block app-vertical-middle">
                <a href="{{ '/users/' . $users[6]->id }}">
                    <img alt="Profile photo" id="profile_photo" class="app-profile-blocked-user-photo app-relative app-square-xl" src="{{ $users[6]->photo_path }}">
                </a>
            </div>

            <div class="app-inline-block m-l-3 app-vertical-middle">
                    <span class="app-people-plus-container app-text-sm app-circle app-inline-block">
                        &#x2795
                    </span>

                <span class="app-text-sm app-color-grey">{{ Carbon\Carbon::parse($users[6]->created_at)->diffForHumans() }}</span>
                <a href="{{ '/users/' . $users[6]->id }}"><strong class="app-text-xl app-block">{{ $users[6]->getName() }}</strong></a>
                <div class="app-text-xs app-color-grey">4 common interests &#8226 5 common likes</div>
            </div>

        </div>
    </div>
@endif

<div class="row">

    <div class="col-xs-12 col-md-6 col-xl-8 col-xxl-9 col-xxxl-10 app-card-b-shadow  p-b-2 p-t-2">
        @for($i=7; ($i<13 && $i < count($users)); $i++)
            <div class="col-md-12 col-xl-6 col-xxl-4 col-xxxl-3 m-b-2 app-inline-block">

                <div class="m-b-1 app-profile-photo app-circle app-square-lg app-inline-block">
                    <a href="{{ '/users/' . $users[$i]->id }}">
                        <img alt="Profile photo" id="profile_photo" class="app-profile-blocked-user-photo app-relative app-square-xl" src="{{ $users[$i]->photo_path }}">
                    </a>
                </div>

                <div class="app-inline-block m-l-2">
                        <span class="app-people-plus-container app-text-sm app-circle app-inline-block">
                            &#x2795
                        </span>
                    <span class="app-text-sm app-color-grey">{{ Carbon\Carbon::parse($users[$i]->created_at)->diffForHumans() }}</span>
                    <strong class="app-text-xl app-block">{{ $users[$i]->getName() }}</strong>
                    <div class="app-text-xs app-color-grey">4 common interests</div>
                    <div class="app-text-xs app-color-grey">5 common likes</div>
                </div>

            </div>
        @endfor
    </div>

    <div class="col-xs-12 col-md-6 col-xl-4 col-xxl-3 col-xxxl-2 m-l-4">

    </div>

</div>

<div class="row">
    <div class="col-xs-12 col-md-6 col-xl-8 col-xxl-9 col-xxxl-10 app-inline-block app-card-b-shadow p-t-2 p-b-2 p-l-1">

        <div class="app-profile-photo app-circle app-square-xl app-inline-block app-vertical-middle">
            <img alt="Profile photo" id="profile_photo" class="app-profile-blocked-user-photo app-relative app-square-xl" src="/img/test/users/1.png">
        </div>

        <div class="app-inline-block m-l-3 app-vertical-middle">
            <span class="app-text-sm app-color-grey">Sponsored</span>
            <strong class="app-text-xxl app-block">Vaude Sport</strong>
            <div class="app-text-xs app-color-grey">Germany's most sustainable brand! Eco-friendly and fair - a winning combination</div>
        </div>

    </div>
</div>

<div class="row">

    <div class="col-xs-12 col-md-6 col-xl-8 col-xxl-9 col-xxxl-10 p-b-2 p-t-2">
        @for($i=13; ($i<19 && $i < count($users)); $i++)
            <div class="col-md-12 col-xl-6 col-xxl-4 col-xxxl-3 m-b-2 app-inline-block">

                <div class="m-b-1 app-profile-photo app-circle app-square-lg app-inline-block">
                    <a href="{{ '/users/' . $users[13]->id }}">
                        <img alt="Profile photo" id="profile_photo" class="app-profile-blocked-user-photo app-relative app-square-xl" src="{{ $users[$i]->photo_path }}">
                    </a>
                </div>

                <div class="app-inline-block m-l-2">
                        <span class="app-people-plus-container app-text-sm app-circle app-inline-block">
                            &#x2795
                        </span>
                    <span class="app-text-sm app-color-grey">{{ Carbon\Carbon::parse($users[$i]->created_at)->diffForHumans() }}</span>
                    <a href="{{ '/users/' . $users[$i]->id }}"><strong class="app-text-xl app-block">{{ $users[$i]->getName() }}</strong></a>
                    <div class="app-text-xs app-color-grey">4 common interests</div>
                    <div class="app-text-xs app-color-grey">5 common likes</div>
                </div>

            </div>
        @endfor
    </div>

</div>
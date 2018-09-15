
@extends('app.profile.public._layouts.profile')

@section('profile-details')

<div class="app-section-x navbar navbar-light app-navbar app-subnavbar">
    <ul class="nav navbar-nav">
        <li id="nav_about" class="nav-item active">
            <a href="" class="app-pub-profile-nav-link nav-link">About</a>
        </li>
        <li id="nav_activities" class="nav-item">
            <a href="{{ $user->getPublicProfileUrl() . '/activities' }}" class="app-pub-profile-nav-link nav-link">Activities</a>
        </li>
        <li id="nav_reviews" class="nav-item">
            <a href="{{ $user->getPublicProfileUrl() . '/reviews' }}" class="app-pub-profile-nav-link nav-link">Reviews</a>
        </li>
        <li id="nav_friends" class="nav-item">
            <a href="{{ $user->getPublicProfileUrl() . '/friends' }}" class="app-pub-profile-nav-link nav-link">Friends</a>
        </li>
    </ul>
</div>

<main class="app-section app-profile-details">
    <div class="row">
        <div class="col-lg-8">

            <div class="m-b-3">
                <h2 class="app-color-grey">Approved interests</h2>
                <span class="app-t-subtitle">Interests approved by others</span>

            </div>

            <div class="m-b-3">
                <h2 class="app-color-grey">About</h2>
                <div class="app-color-gray">
                    {{$user->about}}
                </div>

            </div>

            <div class="m-b-3">
                <h2 class="app-color-grey">Work and professional skills</h2>
                <div class="app-color-gray">
                    {{$user->work}}
                </div>

            </div>

        </div>
        <div class="col-lg-4">
            <div class="m-b-3">

                <h2 class="app-color-grey">Favorite categories</h2>

                @foreach($user->categories_bit as $category_id)
                    <span class="app-tag">{{ trans('models/categories.'.$category_id) }}</span>
                @endforeach

            </div>

            <div>

                <h2 class="app-color-grey">All interests</h2>

                @foreach($user->interests as $interest)
                    <a href="{{ url('/interest/' . str_slug($interest->name) ) }}"><span class="app-tag">{{ $interest->name }}</span></a>
                @endforeach

            </div>
        </div>
    </div>
</main>

@endsection
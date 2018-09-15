
@extends('app.profile.public._layouts.profile')

@section('profile-details')

    <div class="app-section-x navbar navbar-light app-navbar app-subnavbar">
        <ul class="nav navbar-nav">
            <li id="nav_about" class="nav-item">
                <a href="{{ $user->getPublicProfileUrl() . '/about' }}" class="app-pub-profile-nav-link nav-link">About</a>
            </li>
            <li id="nav_activities" class="nav-item active">
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

    <section class="app-section app-profile-details">
        <div id="activities_rows" class="row">
            @include('app._partials.adventures_row', ['adventures' => $activities])
        </div>

        <div id="activities_more_block" class="app-adventures-load-section {{ $showMore ? '' : 'hidden-xs-up' }}">
            <button id="app_button_more" class="btn btn-block app-btn-apply app-border-radius-4">
                <span id="app_adventures_more_text">More</span>
            </button>
        </div>

    </section>

    <div class="app-footer-divider"></div>

@endsection

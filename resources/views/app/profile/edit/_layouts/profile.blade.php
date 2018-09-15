@extends('app._layouts.app')

@section('content')
    <div class="app-section app-profile app-section" xmlns="http://www.w3.org/1999/xhtml">

        <div class="row">
            <div class="col-lg-3">
                <div class="app-card app-profile-block-left p-a-3">
                    <div class="m-b-1 app-profile-photo app-center-block app-circle app-square-xl">
                        <img alt="Profile photo" id="profile_photo" class="app-relative app-square-xl" src="{{ $user->photo_path }}">
                        <div class="app-profile-photo-overlay app-text-uppercase">
                            Change
                        </div>
                    </div>

                    <strong><a id="remove_photo" href="#" class="app-link-green">Remove photo</a></strong>

                    <p class="m-t-1 app-block app-center-block app-text-xl">{{ $user->getName() }}</p>
                    <p class="app-text-sm app-color-grey">{{ $user->getHometown() }}</p>

                    {{--<p class="app-profile-star-age-container m-b-2">
                        <span class="app-profile-star-container app-circle app-inline-block">
                            <svg class="app-profile-star" role="img">
                                <use xlink:href="#svg__profile__activity_star"></use>
                            </svg>
                        </span>

                        <span class="app-inline-block app-color-grey">
                            <span>54 </span><span class="app-s-bullet"></span><span> Age {{ $user->getAge() }}</span>
                        </span>
                    </p>--}}

                    <strong><a href="{{ url('/users/' . Auth::user()->id) }}" class="app-link-green">View public profile</a></strong>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="app-card">

                    @yield('profile-right-block')

                </div>
            </div>
        </div>

    </div>
@endsection

@include('_partials.admin_flash')

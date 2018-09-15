@extends('app._layouts.app')

@section('content')

    <header class="app-section app-bg-color-grey-light">

        <img class="app-photo app-pub-profile-photo app-circle app-square-xl app-vertical-top" src="{{ $user->photo_path }}">

        <div class="app-pub-profile-basic-info app-inline-block app-vertical-top">
            <h1 class="app-pub-profile-basic-text">{{ $user->first_name }} {{ $user->last_name }}</h1>
            <p lclass="app-link-container-grey">{{$user->adventurer_title}}</p>
            <p class="app-color-grey app-pub-profile-basic-text">

                @php($age = $user->getAge())
                @if ($age !== false)
                    <span>Age {{ $age }}</span>
                    <span class="app-s-bullet"></span>
                @endif

                <span>{{$user->getHometown()}}</span>

                @php ($fb_id = $user->getFacebookUserId())
                @if ($fb_id !== false)
                    <span class="app-s-bullet"></span>
                    <span>
                        <a href="https://facebook.com/{{$fb_id}}" target="_blank">
                            <svg class="app-icon app-icon-square">
                                <use xlink:href="#svg__facebook"></use>
                            </svg>
                        </a>
                    </span>
                @endif
            </p>

            @if($user->id != \Illuminate\Support\Facades\Auth::user()->id)
                <div class="col-md-12 col-lg-11">
                    <button id="btn_save" type="submit" class="btn app-btn-apply app-pub-profile-save-btn m-b-1">Add as friend</button>
                    <button id="btn_cancel" type="button" class="btn app-btn-outline-apply m-b-1">Send message</button>
                </div>

                <div class="col-md-12 col-lg-1 p-l-1">
                    <div class="dropdown app-inline-block">
                        <svg id="show_more" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 21px; height: 7px; margin-top: 15px; margin-right: 8px" role="img">
                            <use xlink:href="#svg__option-horizontal"></use>
                        </svg>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="show_more">
                            <a id="block_user" class="dropdown-item" href="#">Block user</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </header>

    @yield('profile-details')

@endsection


<div id="navbar-mobile" class="app-navbar-mobile">
    <div class="app-navbar-mobile-inner">

        {{-- mobile nav / user profile --}}
        @if (Auth::check())

            <div class="app-navbar-mobile-section app-navbar-mobile-section-title app-navbar-mobile-user-block">
                <div class="app-inline-block app-vertical-middle">
                    <img src="{{ Auth::user()->photo_path }}" alt="Photo">
                </div>
                <div class="app-inline-block app-vertical-middle">
                    <span>{{ Auth::user()->getName() }}</span>
                    <a class="app-link-front-darkest-block" href="{{ url('/edit-profile') }}">{{ trans('core.edit_my_profile') }}</a>
                </div>
            </div>

            {{-- mobile nav / user dropdown menu --}}

            <div class="app-navbar-mobile-section app-navbar-mobile-section-links">
                <a class="app-link-front-darkest-block" href="{{ url('/users/' . Auth::user()->id) }}">{{ trans('core.my_profile') }}</a>
                <a class="app-link-front-darkest-block" href="{{ url('/users/' . Auth::user()->id . '/activities') }}">{{ trans('core.my_activities') }}</a>
                <a class="app-link-front-darkest-block" href="{{ url('/users/' . Auth::user()->id . '/reviews') }}">{{ trans('core.my_reviews') }}</a>
                <a class="app-link-front-darkest-block" href="{{ url('/users/' . Auth::user()->id . '/friends') }}">{{ trans('core.my_friends') }}</a>
                <a class="app-link-front-darkest-block" href="{{ url('/messages') }}">{{ trans('core.messages') }}</a>
                <a class="app-link-front-darkest-block" href="{{ url('/notifications') }}">{{ trans('core.notifications') }}</a>
                <a class="app-link-front-darkest-block" href="{{ url('/logout') }}">{{ trans('core.logout') }}</a>
            </div>

        @else

            <div class="app-navbar-mobile-section app-navbar-mobile-buttons">
                <a class="app-block btn btn-sm app-btn-outline app-border-radius-4" href="{{ url('/register') }}">
                    {{--<svg class="app-icon app-icon-before app-icon-lg app-icon-green-front">
                        <use xlink:href="#svg__register"></use>
                    </svg>--}}
                    <span>
                        {{ trans('core.register') }}
                    </span>
                </a>

                <a class="app-block btn btn-sm app-btn-outline app-border-radius-4" href="{{ url('/login') }}">
                    {{--<svg class="app-icon app-icon-before app-icon-lg app-icon-green-front">
                        <use xlink:href="#svg__login"></use>
                    </svg>--}}
                    <span>
                        {{ trans('core.login') }}
                    </span>
                </a>
            </div>

        @endif

        @if (Auth::check())
            <div class="app-navbar-mobile-section app-navbar-mobile-section-title app-font-size-0">
                <svg class="app-navbar-mobile-logo">
                    <use xlink:href="#svg__app_logo"></use>
                </svg>
            </div>
        @endif

        {{-- mobile nav / main links --}}
        {{--@if (Auth::check())--}}
            <div class="app-navbar-mobile-section app-navbar-mobile-section-links app-text-lg">
                <a class="app-link-front-block" href="{{ url('/activities') }}">{{ trans('core.activities') }}</a>
                <a class="app-link-front-block" href="{{ url('/reviews') }}">{{ trans('core.reviews') }}</a>
                <a class="app-link-front-block" href="{{ url('/people') }}">{{ trans('core.people') }}</a>
            </div>
        {{--@endif--}}

        <div class="app-navbar-mobile-divider"></div>

        {{-- mobile nav / footer links --}}
        <div class="app-navbar-mobile-section app-navbar-mobile-section-links">
            <a class="app-link-front-darkest-block" href="{{ url('/about_us') }}">{{ trans('core.about_us') }}</a>
            <a class="app-link-front-darkest-block" href="{{ url('/for_press') }}">{{ trans('core.for_press') }}</a>
            <a class="app-link-front-darkest-block" href="{{ url('/help') }}">{{ trans('core.help') }}</a>
            <a class="app-link-front-darkest-block" href="{{ url('/privacy_policy') }}">{{ trans('core.privacy_policy') }}</a>
            <a class="app-link-front-darkest-block" href="{{ url('/terms_of_service') }}">{{ trans('core.terms_of_service') }}</a>
        </div>

    </div>
</div>

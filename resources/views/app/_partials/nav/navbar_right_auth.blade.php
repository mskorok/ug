
{{-- right user menu --}}

        {{-- notifications button --}}
            <a {{--href="{{ url('/profile/notifications') }}"--}} role="button" class="app-flex-row-col app-item-spacer">
                <svg class="app-navbar-auth-notifications">
                    <use xlink:href="#svg__bell"></use>
                </svg>
            </a>

        {{-- private messages buttons --}}
            <a {{--href="{{ url('/profile/private-messages') }}"--}} role="button" class="app-flex-row-col app-item-spacer">
                <svg class="app-navbar-auth-pm">
                    <use xlink:href="#svg__mail"></use>
                </svg>
            </a>

        {{-- Add - orange circle button with dropdown --}}
        <div class="dropdown app-flex-row-col">
            <button class="dropdown-toggle app-dropdown-toggle-remove app-btn-reset app-item-spacer app-h-100" data-toggle="dropdown">
                <img class="app-navbar-auth-plus" src="/img/app/navbar/plus.png"/>
            </button>
            <div class="dropdown-menu dropdown-menu-right app-dropdown">
                <a href="{{ url('/activities/create') }}" class="dropdown-item">@lang('core.add_activity')</a>
                <a href="{{ url('/reviews/create') }}" class="dropdown-item">@lang('core.add_review')</a>
            </div>
        </div>

        {{-- user profile picture and menu --}}

        <div class="app-flex-row-col app-navbar-auth-user-block">

            <div class="app-relative app-flex-row-col">

                {{-- hamburger overlay for mobile, trigger mobile menu not dropdown on click --}}
                <div class="app-absolute-0 hidden-lg-up" data-id="navbar-hamburger"></div>


                <div class="dropdown app-flex-row-col">

                    <a class="dropdown-toggle app-dropdown-toggle-remove app-flex-row-col" data-toggle="dropdown">
                        <img class="app-navbar-auth-user-photo" src="{{ Auth::user()->photo_path }}"/>
                        {{--<img class="app-navbar-auth-profile" src="/img/app/navbar/profile.png"/>--}}
                        <svg class="app-navbar-auth-hamburger">
                            <use xlink:href="#svg__option-vertical"></use>
                        </svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ url('/users/' . Auth::user()->id) }}" class="dropdown-item">{{ trans('core.my_profile') }}</a>
                        <a href="{{ url('/edit-profile') }}" class="dropdown-item">{{ trans('core.edit_my_profile') }}</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('/users/' . Auth::user()->id . '/activities') }}" class="dropdown-item">{{ trans('core.my_activities') }}</a>
                        <a href="{{ url('/users/' . Auth::user()->id . '/reviews') }}" class="dropdown-item">{{ trans('core.my_reviews') }}</a>
                        <a href="{{ url('/users/' . Auth::user()->id . '/friends') }}" class="dropdown-item">{{ trans('core.my_friends') }}</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('/logout') }}" class="dropdown-item">{{ trans('core.logout') }}</a>
                    </div>
                </div>

            </div>



        </div>


        {{--</li>--}}

    {{--</div>


</ul>--}}

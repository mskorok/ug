
<nav id="navbar" class="navbar navbar-light app-navbar app-flex-row navbar-fixed-top clearfix @if(!Request::is('/')) app-navbar-auth @endif">
{{--<div class="app-relative clearfix">--}}

    {{-- flex col 1 (brand and main menu) --}}
    <div class="app-flex-row-col">
        @include('app._partials.nav.navbar_left')
    </div>

    {{-- flex col 2 - middle (searchbar) --}}
    <div class="app-flex-row-col app-flex-row-col-middle">
    @if (!Request::is('/'))
        <div class="hidden-lg-down app-relative app-navbar-middle">
            @include('app._partials.nav.navbar_search')
        </div>
    @endif
    </div>

    {{-- flex col 3 (right menu) --}}
    <div class="app-flex-row-col navbar-nav">
        @if (Auth::check())
            @include('app._partials.nav.navbar_right_auth')
        @else
            @include('app._partials.nav.navbar_right_guest')
        @endif
    </div>

{{--</div>--}}
</nav>

@include('app._partials.nav.navbar_mobile')

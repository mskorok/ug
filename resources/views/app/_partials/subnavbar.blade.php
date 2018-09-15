
<nav class="navbar navbar-light app-navbar app-subnavbar">

    <ul class="nav navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="#">@lang('core.latest')</a>
        </li>
        <li class="nav-item app-subnavbar-small-item">
            <a class="nav-link" href="#">@lang('core.popular')</a>
        </li>
        {{--@if(Auth::check())
        <li class="nav-item app-subnavbar-small-item">
            <a class="nav-link" href="#">Friend activities</a>
        </li>
        @endif--}}

    </ul>

    <ul class="nav navbar-nav pull-xs-right hidden-md-down">

{{--
        <form name="adventures_categories" id="adventures_categories" class="app-inline-block" action="" method="get">
--}}
            {{--<li class="nav-item dropdown">
                    <button class="nav-link app-btn-reset dropdown-toggle" type="button" role="button" data-toggle="dropdown" data-close-inside="false" aria-haspopup="true" aria-expanded="false">All categories</button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        @foreach ($categories as $id => $category)
                            <ul class="dropdown-item app-dropdown-item-checkbox">
                                <label class="btn-block app-checkbox-label">
                                    <div class="app-checkbox {{ $category['checked'] }}"></div>
                                    <input class="hidden-xs-up" name="categories[{{ $id }}]" type="checkbox" {{ $category['checked'] }} >
                                    <span>{{ $category['name'] }}</span>
                                </label>
                            </ul>
                        @endforeach
                        <li class="dropdown-item">
                            <button type="submit" class="btn app-btn-apply btn-block btn-sm app-border-radius-4">Apply filter</button>
                        </li>
                    </ul>

            </li>--}}
{{--
        </form>
--}}

        <li class="nav-item">
            <a role="button" class="nav-link dropdown-toggle" data-id="show_more_filters">
                @lang('core.show_filters')
            </a>
        </li>

    </ul>

    {{-- mobile right subnavbar hamburger and filters/more menu --}}
    {{--<ul class="nav navbar-nav pull-xs-right hidden-lg-up">
        <li class="nav-item app-subnavbar-small-item pull-xs-right  hidden-lg-up">
            <nav class="navbar-nav dropdown">
                <div class="dropdown-toggle app-subnavbar-dropdown-toggle" data-toggle="dropdown">
                    <button class="app-btn-hidden app-subnavbar-icon">
                        <svg class="app-subnavbar-horizontal-icon">
                            <use xlink:href="#svg__option-horizontal"></use>
                        </svg>
                        <span class="caret"></span>
                    </button>
                </div>
                <ul  class="dropdown-menu app-subnavbar-block-mobile">
                    <li>
                        <div  id="app_mobile_categories_up" class="checkbox app-subnavbar-mobile-title">
                            All categories
                            <svg class="app-subnavbar-menu-icon">
                                <use xlink:href="#svg__menu-down"></use>
                            </svg>
                        </div>
                    </li>
                    <li><div class="checkbox app-subnavbar-mobile-title">Advanced search</div></li>
                </ul>
            </nav>
        </li>
    </ul>--}}
    <div class="pull-xs-right hidden-lg-up">
        <svg class="app-subnavbar-menu-icon" role="button" data-id="show_more_filters">
            <use xlink:href="#svg__option-horizontal"></use>
        </svg>
    </div>

</nav>


{{-- right menu --}}
<button data-id="navbar-hamburger" class="navbar-toggler app-navbar-hamburger hidden-lg-up">
    ☰
</button>

<ul class="nav navbar-nav pull-xs-right hidden-md-down">

    <li class="nav-item">
        <a class="nav-link app-navbar-link-bordered" href="{{ url('/register') }}">
            <div>
                        <span>
                            {{ trans('core.register') }}
                        </span>
            </div>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/login') }}">
            {{ trans('core.login') }}
        </a>
    </li>

    <li class="nav-item dropdown">
        <button class="nav-link app-btn-reset dropdown-toggle" id="dropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @if (App::getLocale() === 'en')
                {{ trans('core.english') }}
            @else
                {{ trans('core.german') }}
            @endif
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown">
            @if (App::getLocale() === 'en')
                <a class="dropdown-item" href="{{ trans_url('de') }}">{{ trans('core.german') }}</a>
            @else
                <a class="dropdown-item" href="{{ trans_url() }}">{{ trans('core.english') }}</a>
            @endif
        </div>
    </li>

</ul>

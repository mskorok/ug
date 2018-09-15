<div class="container-fluid">
<nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
    <a class="navbar-brand" href="{{ url('/admin') }}">Admin panel</a>

    @if (Auth::guard('admin')->check())
    <ul class="nav navbar-nav">
        <li class="nav-item @if(Request::is('/admin/users')) active @endif">
            <a class="nav-link" href="/admin/users">Users <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item @if(Request::is('/admin/categories')) active @endif">
            <a class="nav-link" href="/admin/categories">Categories</a>
        </li>
        <li class="nav-item @if(Request::is('/admin/adventures')) active @endif">
            <a class="nav-link" href="/admin/adventures">Adventures</a>
        </li>
        <li class="nav-item @if(Request::is('/admin/reviews')) active @endif">
            <a class="nav-link" href="/admin/reviews">Reviews</a>
        </li>
        <li class="nav-item @if(Request::is('/admin/countries')) active @endif">
            <a class="nav-link" href="/admin/countries">Countries</a>
        </li>
    </ul>

    @endif

    <ul class="nav navbar-nav pull-xs-right">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">View site</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/administrators') }}">Administrators</a>
        </li>
        @if (Auth::guard('admin')->guest())
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin/login') }}">Login</a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="dropdownMenu1" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::guard('admin')->user()->name }}<span class="caret"></span>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <a class="dropdown-item" href="{{ url('/admin/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
                </ul>
            </li>
        @endif
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                @if (App::getLocale() === 'en')
                    EN
                @else
                    DE
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                @if (App::getLocale() === 'en')
                    <a class="dropdown-item" href="{{ trans_url('de') }}">DE</a>
                @else
                    <a class="dropdown-item" href="{{ trans_url() }}">EN</a>
                @endif
            </div>
        </li>
    </ul>
</nav>
</div>

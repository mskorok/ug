
{{-- Logo --}}
<a class="navbar-brand" href="{{ url('/') }}">

    @if(Request::is('/'))
        <svg>
            <use xlink:href="#svg__app_logo"></use>
        </svg>
    @else
        <svg>
            <use xlink:href="#svg__app_logo_small"></use>
        </svg>
    @endif

</a>

{{-- Main menu, desctop only --}}
@if (!Request::is('/'))
    <ul class="nav navbar-nav hidden-md-down app-inline">
        <li class="nav-item @if(Request::is('/activities')) active @endif">
            <a class="nav-link" href="{{ url('/activities') }}">{{ trans('core.activities') }} <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item @if(Request::is('/reviews')) active @endif">
            <a class="nav-link" href="{{ url('/reviews') }}">{{ trans('core.reviews') }}</a>
        </li>
        <li class="nav-item @if(Request::is('/people')) active @endif">
            <a class="nav-link" href="{{ url('/people') }}">{{ trans('core.people') }}</a>
        </li>
    </ul>
@endif

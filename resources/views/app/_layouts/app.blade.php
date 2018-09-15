@extends('_layouts.html')

@section('styles')
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
@endsection

@section('body-class') body-navbar-top-spacer @endsection

@section('body')

    @include('app._partials.navbar')

    @yield('content')

    @include('app._partials.footer')

    @if (!Auth::check() && !isset($_COOKIE['app_legal_closed']))
        @include('app._partials.alert_legal')
    @endif

@endsection

@section('app_scripts')
    <script src="{{ elixir('js/app.js') }}"></script>
@endsection

@extends('app._layouts.app')

@section('title') @yield('error_title') - @endsection

@section('content')

    <div class="container-fluid app-error">
        <h1>@yield('error_title')</h1>
        <p>@yield('message')</p>
        @if(!Route::is('/'))
            <a href="{{ URL::previous() }}" class="btn btn-primary">Go to previous page</a>
        @endif
    </div>
@endsection

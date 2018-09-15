@extends('_layouts.html')

@section('styles')
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
@endsection

@section('body-class') app-flex-col-container app-auth app-gradient-green @endsection

@section('body')
    <div class="app-flex-col app-container">

        <nav class="app-flex-col-row app-auth-nav">
            <div class="row">
                <div class="col-md-6 app-auth-logo-col">
                    <a href="{{ url('/') }}"><img src="/img/app/auth/logo.png" class="app-auth-logo" alt="Logo"></a>
                </div>
                <div class="col-md-6 app-auth-back-col">
                    @php($prev = URL::previous())
                    <?php
                    //dd(URL::previous());
                    ?>
                    @if ($prev === url('/'))
                        <a href="{{ $prev }}">← @lang('app/auth.btn_back_index')</a>
                    @else
                        <a href="{{ $prev }}">← @lang('app/auth.btn_back')</a>
                    @endif
                </div>
            </div>
        </nav>

        <div class="app-flex-col-row app-container-1600">
            <header class="app-section-x">
                <h1 id="auth_title" class="app-heading app-auth-title">@yield('auth_title')</h1>
                <h4 id="auth_subtitle" class="app-subheading">@yield('auth_subtitle')</h4>
                <p class="app-text-xl">@yield('auth_title_desc')</p>
            </header>

            <main class="app-auth-main">

                @yield('main')

            </main>
        </div>

        <footer class="app-flex-col-row app-auth-footer" id="auth_footer">

            @yield('footer')

        </footer>

    </div>

@endsection


@section('app_scripts')
    <script src="{{ elixir('js/app.js') }}"></script>
@endsection

<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ACP - {{ trans('core.project_name') }} ({{env('APP_ENV')}})</title>
    <link href="{{ elixir('css/admin.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/png">
</head>
<body class="@yield('body-class')">

@include('_partials.admin_navbar')

<main class="container-fluid">
    <div class="card">
        <div class="card-header">@yield('header')</div>
        <div class="card-block">
            @yield('content')
        </div>
    </div>
</main>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>--}}


@include('_partials.admin_footer')

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
@include('_partials.javascript_variables')
<script src="{{ elixir('js/admin.js') }}"></script>
</body>
</html>

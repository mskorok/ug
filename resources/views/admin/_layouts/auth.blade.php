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
<body class="admin-auth">

@yield('content')

@include('_partials.javascript_variables')
<script src="{{ elixir('js/admin.js') }}"></script>
</body>
</html>

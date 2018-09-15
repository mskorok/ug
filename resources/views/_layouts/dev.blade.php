<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('app.name') }}</title>
    <link href="{{ elixir('css/admin.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="/ug-favicon.png" type="image/png">
</head>
<body>

<main class="container p-t-1">
    @yield('content')
</main>

<script src="{{ elixir('js/admin.js') }}"></script>
</body>
</html>

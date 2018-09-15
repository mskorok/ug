<!DOCTYPE html>
<html lang="{{ App::getLocale()  }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') {{ trans('core.project_name') }}</title>
    <link rel="shortcut icon" href="/ug_favicon.png" type="image/png">
</head>
<body>

<header>
    <a href="https://uraubsglueck.com" class="email-logo">
        <img src="https://urlaubsglueck.com/img/app/navbar/logo1.png" alt="">
        Urlaubsglück
    </a>
</header>

<div class="email-main">
    @yield('main')
</div>

<footer>
    <h3>Urlaubsglück</h3>
    <p>2016 © All rights reserved.</p>
</footer>

</body>
</html>

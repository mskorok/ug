<!DOCTYPE html>
<html lang="{{ App::getLocale()  }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>@yield('title') {{ trans('core.project_name') . ' (' . env('APP_ENV') . ')' }} </title>
    <link rel="shortcut icon" href="/ug_favicon.png" type="image/png">
    @yield('styles')
{{--
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
--}}
    <style>
        body {
            opacity: 1;
            transition: 1s opacity;
        }
        body.fade-out {
            opacity: 0;
            transition: none;
        }
    </style>
</head>
<body class="@yield('body-class')">
<script>
    document.body.classList.add('fade-out');
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.remove('fade-out');
    });
</script>
@yield('body')

@include('_partials.javascript_variables')

@yield('javascript')
@yield('app_scripts')
<?php echo file_get_contents(public_path('svg/sprites.svg')); ?>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-76824221-1', 'auto');
    ga('require', 'linkid');
    ga('send', 'pageview');
</script>

</body>
</html>

@extends('app._layouts.auth')

@section('auth_title') @lang('app/auth.title_reg') @endsection

@section('auth_subtitle')
    @if (isset($_GET['utm_source']) && Lang::has('app/auth.utm_'.$_GET['utm_source']))
        {{ trans('app/auth.utm_'.$_GET['utm_source']) }}
    @endif
@endsection

@section('main')
    @include('_partials.admin_flash')
    <form id="reg_form" role="form" method="POST" enctype="multipart/form-data">

        <div id="form_alert_container" class="form-group"></div>

        {!! csrf_field() !!}

        <section id="step1">
            @include('app.auth.step1')
        </section>

        <section id="step2" class="hidden-xs-up">
            @include('app.auth.step2')
        </section>

        <section id="step3" class="hidden-xs-up">
            @include('app.auth.step3', ['data' => $categories])
        </section>

        <section id="step4" class="hidden-xs-up">
            @include('app.auth.step4')
        </section>

    </form>
@endsection

@section('footer')
    <p>
        @lang('app/auth.subtitle_reg') <a class="app-link-green" href="{{ url('/login') }}">@lang('app/auth.subtitle_reg_login')!</a>
    </p>
    <p>
        @lang('app/auth.reg_confirm', [
            'privacy' => '<a href="#">'.trans('core.privacy_policy').'</a>',
            'service' => '<a href="#">'.trans('core.terms_of_service').'</a>'
         ])
    </p>
@endsection

@section('javascript')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script type="text/javascript">function handleClientLoad() { RegisterStep1Controller.handleGoogleClientLoad(); }</script>
    <script src="https://apis.google.com/js/platform.js?onload=handleClientLoad" async defer></script>
    <script type="text/javascript">
        Server.lang.section2title = '@lang('app/auth.section2_title')';
        Server.lang.section2subtitle = '@lang('app/auth.section2_subtitle')';
        Server.lang.section3title = '@lang('app/auth.section3_title')';
        Server.lang.section3subtitle = '@lang('app/auth.section3_subtitle')';
        Server.lang.section4title = '@lang('app/auth.section4_title')';
        Server.lang.section4subtitle = '@lang('app/auth.section4_subtitle')';
        Server.lang.addPhoto = '@lang('app/auth.add_photo')';
        Server.lang.changePhoto = '@lang('app/auth.change_photo')';
        Server.lang.alertEmailTaken = '@lang('app/auth.alert_email_taken')';
    </script>
@endsection

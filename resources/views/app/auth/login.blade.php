@extends('app._layouts.auth')

@section('auth_title') @lang('app/auth.title_login') @endsection

@section('auth_title_desc')

@endsection

@section('main')
    <form role="form" method="POST" action="{{ url('/login') }}" novalidate>

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-lg-5 app-auth-social-block">

                <div>
                    <div id="social_alert_container" class="form-group"></div>

                    <button type="button" id="btn_fb" class="btn app-soc-btn app-soc-btn-facebook">
                        <svg>
                            <use xlink:href="#svg__social__facebook"></use>
                        </svg>
                        <span>
                            @lang('app/auth.btn_login_facebook')
                        </span>
                    </button>

                    <button type="button" id="btn_google" class="btn app-soc-btn app-soc-btn-google">
                        <svg>
                            <use xlink:href="#svg__social__google"></use>
                        </svg>
                        <span>
                            @lang('app/auth.btn_login_google')
                        </span>
                    </button>

                </div>

            </div>

            <div class="col-lg-2 app-auth-middle-block">

                <div class="app-auth-line hidden-lg-down"></div>
                <div class="app-auth-or">@lang('app/auth.or')</div>
                <div class="app-auth-line hidden-lg-down"></div>

            </div>

            <div class="col-lg-5 app-auth-email-block">

                @if(session('email-login-failure'))
                    <div id="email_alert_container">
                        <div id="email_alert" class="form-group app-alert">
                            @if(session('email-login-failure') == 'default')
                                @lang('app/auth.alert_invalid_email_login') <a href="/restore-password">@lang('app/auth.ask_forgot_password')</a>
                            @else
                                {{ Session::get('email-login-failure') }}
                            @endif
                        </div>
                    </div>
                @endif

                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                    <input type="email" class="form-control" name="email" id="email" value="{{--{{ old('email') }}--}}test@user.com" placeholder="@lang('app/auth.email')" required>
                    @if ($errors->has('email'))
                        <small class="text-help">{{ $errors->first('email') }}</small>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <input type="password" class="form-control" name="password" id="password" placeholder="@lang('app/auth.password')" minlength="8" value="12345678" required>
                    @if ($errors->has('password'))
                        <small class="text-help">{{ $errors->first('password') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <div class="app-auth-checkbox"></div>
                            <input value="0" class="hidden-xs-up" name="remember" id="remember" type="checkbox">
                            @lang('app/auth.btn_remember_me')
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    {{--<button id="btn_email" type="submit" class="btn btn-secondary">
                        Sign in
                    </button>--}}
                    <button id="btn_email" type="submit" class="btn btn-primary">
                        @lang('app/auth.btn_login_email')
                    </button>
                </div>

                <div class="form-group pull-xs-left">
                    <a href="{{ url('/password/reset') }}">@lang('app/auth.ask_forgot_password')</a>
                </div>

            </div>
            <input type="hidden" id="fb_id" name="facebook_id">
        </div>
    </form>
@endsection

@section('footer')
    @lang('app/auth.subtitle_login') <a class="app-link-green" href="/register">@lang('app/auth.subtitle_login_reg')!</a>
@endsection

@section('javascript')
    <script type="text/javascript">function handleClientLoad() { RegisterStep1Controller.handleGoogleClientLoad(); }</script>
    <script src="https://apis.google.com/js/platform.js?onload=handleClientLoad" async defer></script>
@endsection

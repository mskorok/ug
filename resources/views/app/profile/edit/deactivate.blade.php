<div class="p-a-2">

    <section class="{{ ! empty($user->password) ? 'app-card-b-shadow' : '' }} p-b-2">
        <h3 class="m-b-1">Deactivate your account</h3>

        <div id="deactivation_error_alert" class="alert alert-danger hidden-xs-up form-group"></div>

        <div id="success_alert" class="alert alert-success hidden-xs-up" role="alert">
            {{ trans('profile.account_deactivated') }}
        </div>

        <p>
            Deactivating your account will disable your Profile and remove your name and photo from most things that you've
            shared on Urlaubsgluck. Some information may still be visible to others, such as your name in their Friends list
            and messages that you've sent.
        </p>

    </section>

    @if(! empty($user->password))
    <section class="p-t-2 p-b-2">
        <h5>Please enter your account password to continue</h5>

        <p>
            By entering your password and pressing "Deactivate now" you accept that your account will be deactivated.
        </p>

        <form id="deactivate_form" method="POST">
            {!! csrf_field() !!}

            <div id="alert_container" class="form-group"></div>

            <div id="change_pwd_success" class="alert alert-success hidden-xs-up" role="alert">
                {{ trans('passwords.password_changed') }}
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-4 col-form-label text-sm-right" >Account password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password" placeholder="Account password" name="password" minlength="{{ config('auth.min_password_length') }}" required>
                </div>
            </div>
        </form>
    </section>
    @else
        <form id="deactivate_form" class="hidden_xs_up" method="POST">
            {!! csrf_field() !!}
        </form>
    @endif

    <strong><a id="deactivate" href="{{ url('/') }}" class="app-link-green">Deactivate your account</a></strong>

</div>

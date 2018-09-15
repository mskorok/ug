<div class="p-a-2">

    <h3 class="m-b-1">Change password</h3>

    <form id="change_password_form" method="POST">
        {!! csrf_field() !!}

        <div id="alert_container" class="form-group"></div>

        <div id="change_pwd_success" class="alert alert-success hidden-xs-up" role="alert">
            {{ trans('passwords.password_changed') }}
        </div>

        @if(! empty($user->password))
            <div class="form-group row">
                <label for="old_password" class="col-sm-4 col-form-label text-sm-right" >Current password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="old_password" placeholder="Currenrt password" name="old_password" required>
                </div>
            </div>
        @endif

        <div class="form-group row">
            <label for="password" class="col-sm-4 col-form-label text-sm-right" >New password</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="password" placeholder="New password" name="password" minlength="{{ config('auth.min_password_length') }}" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="password_confirmation" class="col-sm-4 col-form-label text-sm-right">Confirm password</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm password" name="password_confirmation" required>
            </div>
        </div>

        <button id="btn_change_password" type="button" class="btn app-btn-apply">Change</button>

    </form>

</div>

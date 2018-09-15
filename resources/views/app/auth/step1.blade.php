<div class="row">

    <div class="col-lg-5 app-auth-social-block">

        <div>
            <button type="button" id="btn_fb" class="btn app-soc-btn app-soc-btn-facebook">
                <svg>
                    <use xlink:href="#svg__social__facebook"></use>
                </svg>
                <span>
                    @lang('app/auth.btn_reg_facebook')
                </span>
            </button>
            <button type="button" id="btn_google" class="btn app-soc-btn app-soc-btn-google">
                <svg>
                    <use xlink:href="#svg__social__google"></use>
                </svg>
                <span>
                    @lang('app/auth.btn_reg_google')
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

            <div id="email_alert_container" class="form-group"></div>

            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="@lang('app/auth.email')" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="@lang('app/auth.password')" minlength="8" required>
            </div>

            <div class="form-group">
                <button id="btn_email" type="button" class="btn btn-primary">
                    @lang('app/auth.btn_reg_email')
                </button>
            </div>

    </div>
    <input type="hidden" id="social_id" name="social_id">
    <input type="hidden" id="social_provider" name="social_provider">
</div>

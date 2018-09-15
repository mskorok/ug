
@section('auth_title') 123 @endsection

@section('auth_subtitle')
    123
@endsection

<div class="col-lg-6 col-xxl-4 offset-lg-3 offset-xxl-4">

    {{--<div id="photo_popup" class="modal modal-open modal-dialog">

        <div id="photo_preview_container"></div>
        <div role="button" id="photo_crop_btn">Crop photo</div>
        <div role="button" id="photo_rotate_btn">Rotate photo</div>

    </div>--}}

    <div id="photo_popup" hidden>
        <div class="app-modal-overlay">

            <div class="app-modal">

                <h4 data-id="add_or_change_photo_label">@lang('app/auth.add_photo')</h4>

                <div id="photo_preview_container"></div>

                <button class="btn btn-secondary m-t-1 m-b-1" type="button" id="photo_rotate_btn">@lang('app/auth.rotate_photo')</button>

                <button class="btn btn-primary" type="button" id="photo_crop_btn">@lang('app/auth.save_photo')</button>

            </div>

        </div>
    </div>


    <div class="app-auth-photo-container">

        <svg data-id="add_photo" id="photo_preview_empty" role="button" class="app-icon-add-photo">
            <use xlink:href="#svg__auth__add_avatar_hover"></use>
            <use xlink:href="#svg__auth__add_avatar"></use>
        </svg>
        <img src="" alt="Profile photo preview" data-id="add_photo" id="photo_preview" class="app-auth-avatar" data-mirror="reg_form.photo_path">

        <div class="app-auth-photo-col">

            <div data-id="add_photo" role="button" class="app-auth-photo-btn">
                <svg class="app-icon">
                    <use xlink:href="#svg__auth__add_photo"></use>
                </svg>
                <span data-id="add_or_change_photo_label">@lang('app/auth.add_photo')</span>
            </div>

            <div id="remove_photo" role="button" class="app-auth-photo-btn" hidden>
                <svg class="app-icon">
                    <use xlink:href="#svg__auth__remove_photo"></use>
                </svg>
                <span>@lang('app/auth.remove_photo')</span>
            </div>

            <input type="file" name="photo_path" id="photo" class="hidden-xs-up">
        </div>
    </div>

    <div class="form-group">
        <input type="text" class="form-control" name="name" id="name" placeholder="@lang('app/auth.placeholder_name')" required>
    </div>

    <input type="hidden" id="location_lat" name="location_lat" value="">
    <input type="hidden" id="location_lng" name="location_lng" value="">
    <input type="hidden" id="place_location" name="place_location" value="">
    <input type="hidden" id="place_id" name="place_id" value="">

    <div class="form-group app-relative">
        <svg width="22" height="22" class="app-absolute-right-block m-r-1">
            <use xlink:href="#svg__location" fill="#BBB"></use>
        </svg>
        <input type="text" name="hometown_name" id="hometown_name" placeholder="@lang('app/auth.placeholder_hometown')" class="form-control" autocomplete="off" required>
    </div>

    <div class="row form-row">

        <div class="col-xs-3">
            <div class="form-group form-group-select-arrow">
                <select class="form-control" id="birth_day" name="birth_day" placeholder="@lang('app/auth.placeholder_day')" required>
                    @for ($i = 1; $i <= 31; $i++)
                        <option>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-xs-6">
            <div class="form-group form-group-select-arrow">
                <select class="form-control" id="birth_month" name="birth_month" placeholder="@lang('app/auth.placeholder_birth_month')" required>
                    @for($k = 1; $k <= 12; $k++)
                    <option value="{{ $k }}">{{ trans('date.month_' . $k) }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="form-group form-group-select-arrow">
                <select class="form-control" id="birth_year" name="birth_year" placeholder="@lang('app/auth.placeholder_year')" required>
                    @for ($i = 1950; $i <= date("Y"); $i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>
        <input id="birth_date" name="birth_date" type="hidden">
    </div>

    <div class="form-group">
        <div class="checkbox">
            <label>
                <div class="app-auth-checkbox"></div>
                <input class="hidden-xs-up" type="checkbox" name="profile_show_age" id="show_age">
                @lang('app/auth.show_age')
            </label>
        </div>
    </div>

    <div class="form-group">
        <div id="gender" class="app-auth-radio-group clearfix">
            <label class="app-auth-radio" checked>
                <input class="hidden-xs-up" type="radio" name="gender_sid" id="gender_1" value="1" checked>
                @lang('models/gender.1')
            </label>
            <label class="app-auth-radio">
                <input class="hidden-xs-up" type="radio" name="gender_sid" id="gender_2" value="2">
                @lang('models/gender.2')
            </label>
        </div>
    </div>
    <input type="hidden" name="profile_locale" id="locale" value="{{ App::getLocale() }}">
    <button id="btn_step2" class="btn btn-primary" type="button">@lang('app/auth.continue')</button>

</div>

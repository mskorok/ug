<form id="edit_profile_form" method="POST">

    {!! csrf_field() !!}

    <input type="file" name="photo_path" id="photo_file_inp" class="hidden-xs-up" value="{{ $user->photo_path }}">

    <section class="app-card-b-shadow p-a-3">
        <h6 class="app-t-subtitle">Required</h6>

        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label text-sm-right">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ $user->getName() }}" required>
            </div>
        </div>

        {{-- Hometown --}}

        <input type="hidden" id="hometown_location" name="hometown_location" value="">
        <input type="hidden" id="hometown_id" name="hometown_id" value="">
        <input type="hidden" id="hometown_lat" name="hometown_lat" value="">
        <input type="hidden" id="hometown_lng" name="hometown_lng" value="">
        <div class="form-group row">
            <label for="hometown_name" class="col-sm-3 col-form-label text-sm-right">Hometown</label>
            <div class="col-sm-9">
                <input type="text" class="form-control app-new-activities-form-input" name="hometown_name" id="hometown_name" value="{{ $user->hometown_name }}" placeholder="Hometown" required autocomplete="off">
                <svg class="app-new-activities-form-icon">
                    <use xlink:href="#svg__location"></use>
                </svg>
            </div>
        </div>

        <div class="form-group row">
            <label for="gender" class="col-sm-3 col-form-label text-sm-right">Gender</label>
            <div class="col-sm-3 form-group-select-arrow">
                <div class="form-group">
                    <select id="gender" class="form-control" name="gender_sid" required>
                        <option value="1" @if($user->gender_sid == 1) selected @endif>Male</option>
                        <option value="2" @if($user->gender_sid == 2) selected @endif>Femail</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="interest_list" class="col-sm-3 col-form-label text-sm-right">Interested in</label>
            <div id="interest_list" class="col-sm-9">
                <ul class="app-padding-left-0">
                    @foreach($user->interests()->get() as $interest)
                        <li class="app-tag app-s-close" data-id="{{ $interest->id }}">{{ $interest->name }}</li>
                    @endforeach
                </ul>
                @foreach($user->interests()->get() as $interest)
                    <input type="hidden" name="interest_list[]" value="{{ $interest->id }}">
                @endforeach
                <div id="search_interests_autocomplete" class="app-search-autocomplete col-lg-8 app-padding-left-0">
                    <input id="search_interests" type="search" class="app-search-input form-control" placeholder="Type your interest keyword">
                    <button type="button" id="btn_add_interest" class="app-search-add-item">Add</button>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="categories_bit" class="col-sm-3 col-form-label text-sm-right">Categories I like</label>
            <div id="categories_bit" class="col-sm-9">
                <ul class="app-padding-left-0">
                    @foreach($user->categories_bit as $id)
                        <li class="app-tag app-s-close" data-id="{{ $id }}">{{ trans('models/categories.'.$id) }}</li>
                    @endforeach
                </ul>
                @foreach($user->categories_bit as $id)
                    <input type="hidden" name="categories_bit[]" value="{{ $id }}">
                @endforeach

                <div class="col-sm-8 app-padding-left-0">
                    <div class="form-group form-group-select-arrow">
                        <select id="category-names" class="form-control" placeholder="View categories">
                            @foreach($user->getNotSelectedCategories() as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            @include('_partials.date_selector', [
                    'id' => 'birth_date',
                    'date' => $user->birth_date
                ])
        </div>

        <div class="form-group row">
            <div class="offset-sm-3 checkbox">
                <label>
                    <div class="app-checkbox {{ $user->profile_show_age ? '' : 'checked' }} m-r-1"></div>
                    <input class="hidden-xs-up form-control" type="checkbox" name="dont_show_age" id="show_age">
                    Don't show my age to others
                </label>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label text-sm-right">E-mail
                <svg class="app-profile-keylock app-icon app-icon-green app-inline-block app-icon-after" role="img">
                    <use xlink:href="#svg__profile__keylock"></use>
                </svg>
            </label>
            <div class="col-sm-9">
                <input type="email" class="form-control" id="email" placeholder="mail@example.de" name="email" value="{{ $user->email }}">
                <p class="app-text-sm">We won't share your private e-mail address with other Urlaubsgluck users</p>
            </div>
        </div>

    </section>

    <section class="app-card-b-shadow p-a-3">
        <h6 class="app-t-subtitle">Optional</h6>

        @if ($user->getFacebookUserId() || $user->getGoogleUserId())
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label text-sm-right">Social network</label>
                <div class="col-sm-9">
                    @if ($user->getFacebookUserId() || $user->getGoogleUserId())
                        <div id="alert_disconnect_social" class="alert alert-danger hidden-xs-up" role="alert">
                            <button id="alert_disconnect_social_close" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <span id="alert_disconnect_social_text"></span>
                        </div>
                    @endif

                    @if ($user->getFacebookUserId())
                        <div>
                            <button id="btn_disconnect_fb" name="disconnect_fb" type="button" class="btn app-btn-outline-apply app-profile-social-button">Disconnect Facebook account</button>
                            <input type="hidden" name="disconnect_fb" value="0">
                        </div>
                    @endif
                    @if ($user->getGoogleUserId())
                        <div>
                            <button id="btn_disconnect_google" name="disconnect_google" type="button" class="btn app-btn-outline-apply app-profile-social-button">Disconnect Google account</button>
                            <input type="hidden" name="disconnect_google" value="0">
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="form-group row">
            <label for="about" class="col-sm-3 col-form-label text-sm-right">About</label>
            <div class="col-sm-9">
                    <textarea class="form-control" id="about" placeholder="140 characters about you" name="about" maxlength="140">
                        {{ $user->about }}
                    </textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="work" class="col-sm-3 col-form-label text-sm-right" maxlength="140">Work</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="work" placeholder="Your job title" name="work" value="{{ $user->work }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="language_list" class="col-sm-3 col-form-label text-sm-right">Languages spoken</label>
            <div id="language_list" class="col-sm-9">
                <ul class="app-padding-left-0">
                    @foreach($user->languages()->get() as $language)
                        <li class="app-tag" data-id="{{ $language->id }}">{{ $language->name }}</li>
                    @endforeach
                </ul>
                @foreach($user->languages()->get() as $language)
                    <input type="hidden" name="language_list[]" value="{{ $language->id }}">
                @endforeach
                <div id="search_languages_autocomplete" class="app-search-autocomplete col-lg-8 app-padding-left-0">
                    <input id="search_languages" type="search" class="app-search-input form-control" placeholder="e.g. German">
                    <button type="button" id="add_language" class="app-search-add-item">Add</button>
                </div>
            </div>
        </div>
    </section>

    <div class="p-a-3">
        <div class="m-l-1 form-group row">
            <button id="btn_save" type="submit" class="btn app-btn-apply">Save changes</button>
            <button id="btn_cancel" type="button" class="btn btn-link app-link-grey">Cancel changes</button>
        </div>
    </div>
</form>

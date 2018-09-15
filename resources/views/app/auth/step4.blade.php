
<div id="user-intrests" class="col-lg-8 col-xxl-6 offset-lg-2 offset-xxl-3">


    <div id="search_autocomplete" class="app-search-autocomplete app-dropdown">
        <input id="search" type="search" class="app-search-input form-control" placeholder="@lang('app/auth.placeholder_interest_autocomplete')" autocomplete="off">
        <button type="button" id="add_interest" class="app-search-add-item">@lang('app/auth.btn_add')</button>
    </div>

    <div id="interests"></div>

    <div class="app-auth-interests-control">
        <button type="button" id="load_more_interests" class="app-auth-load-more">@lang('app/auth.btn_load_more_interests')</button>
    </div>

    <button id="btn_finish" class="btn btn-primary app-auth-btn" type="button" disabled>@lang('app/auth.btn_finish')</button>

</div>

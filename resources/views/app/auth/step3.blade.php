
<div id="user-categories" class="col-lg-8 col-xxl-6 offset-lg-2 offset-xxl-3">

    @include('_partials.multi_select_list',
        [
            'input' => 'categories_bit',
            'class' => 'app-list-item-faded',
            'data' => $data
        ]
    )
    <button id="btn_step3" class="btn btn-primary app-auth-btn" type="button" disabled>@lang('app/auth.continue')</button>

</div>

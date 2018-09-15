
@if(Session::has('alert'))
    <div class="alert alert-{{ session('alert_type') ?? 'success' }} alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        @lang(session('alert'), session('alert_params') ?? [])
    </div>
@endif

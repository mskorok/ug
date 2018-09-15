@if(session('alert'))
    <div class="alert alert-{{ session('alert_type') ?? 'info' }} alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('alert') }}
    </div>
@endif

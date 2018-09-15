
<section class="app-start-adventure app-gradient-green">

    <h2 class="app-start-adventure-title">{{ trans('app/index.start_adventure_title') }}</h2>

    <div class="app-column-middle">
        <form id="start_adventure" name="start_adventure" method="POST" action="">
            <div class="form-group">
                <input type="text" id="what_would_like_to_do" class="form-control app-box-shadow-3" name="what_would_like_to_do" placeholder="{{ trans('app/index.start_adventure_placeholder') }}" required>
            </div>
            <a id="index_start_adventure" href="{{ url('/register?utm_source=index_start_adventure&utm_medium=link&utm_campaign=urlaubsglueck') }}" class="btn btn-primary w-100">{{ trans('app/index.start_adventure_btn') }}</a>
        </form>
    </div>

</section>

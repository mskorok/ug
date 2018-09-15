
<section class="app-section">

    <h2 class="app-title app-index-title">{{ trans('app/index.activities_title') }}</h2>

    <h4 class="app-subtitle app-index-subtitle">{{ trans('app/index.activities_desc') }}</h4>

{{--
    @include('app._partials.adventures_row', ['adventures' => $adventures])
--}}

    <div class="app-container-1600">
        <div class="row">
        @foreach($adventures as $adventure)
            <div class="col-xl-4">
                @include('app._partials.adventure_block', ['adventure' => $adventure])
            </div>
        @endforeach
        </div>

        <a href="{{url('/activities')}}" class="app-index-browse-link">{{ trans('app/index.activities_browse_all') }}</a>
    </div>

</section>

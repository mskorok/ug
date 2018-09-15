
@extends('app._layouts.app')
@section('content')
    @include('app._partials.subnavbar')
    {{--<section class="app-categories-buttons">
        <div id="app_mobile_categories" class="app-adventures-categories  hidden-lg-up hidden-xs-up">
            @foreach ($categories as $id => $category)
                <button class="btn app-adventures-categories-button">{{ $category['name'] }}
                    <div class="close">x</div>
                </button>
            @endforeach
        </div>
    </section>--}}

    @include('app._partials.filters')

    <section class="app-adventures">
        @include('app._partials.flash')

        {{--<div class="app-adventures-title">Look at the latest added activities</div>--}}
        <div id="app_activity_rows">
            <div class="row">
                @include('app._partials.adventures_row', ['adventures' => $adventures])
            </div>
        </div>
        @if ($showMore)
            <div class="app-adventures-load-section">
                <button id="app_button_more" class="btn btn-block app-btn-apply app-border-radius-4">
                    <span id="app_adventures_more_text">@lang('core.load_more')</span>
                </button>
            </div>
        @endif

        <div class="text-xs-center m-t-3">
                <svg role="button" id="scroll_top" width="40" height="40" class="app-icon-green">
                    <use xlink:href="#svg__circular_arrow_up"></use>
                </svg>
        </div>


        <div class="app-footer-divider"></div>
    </section>
@endsection

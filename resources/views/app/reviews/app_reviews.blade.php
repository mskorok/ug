
@extends('app._layouts.app')
@section('content')
    @include('app._partials.subnavbar')
    {{--<section class="app-categories-buttons">--}}
        {{--<div id="app_mobile_categories" class="app-reviews-categories  hidden-lg-up hidden-xs-up">--}}
            {{--@foreach ($categories as $id => $category)--}}
                {{--<button class="btn app-reviews-categories-button">{{ $category['name'] }}--}}
                    {{--<div class="close">x</div>--}}
                {{--</button>--}}
            {{--@endforeach--}}
        {{--</div>--}}
    {{--</section>--}}
    @include('_partials.admin_flash')
    <section class="app-reviews">
        {{--<div class="app-reviews-title">Latest reviews</div>--}}
        <div id="app_review_rows">
                @include('app._partials.reviews_row', ['reviews' => $reviews])
        </div>
        @if ($showMore)
            <div class="app-reviews-load-section">
                <button id="app_button_more" class="btn btn-block app-btn-apply app-border-radius-4">
                    <span id="app_reviews_more_text">More</span>
                </button>
            </div>
        @endif
    </section>
@endsection

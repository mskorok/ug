@extends('app._layouts.app')

@section('styles')
    <link href="{{ elixir('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('app.index.promo')

    @include('app.index.how_it_works')

    @include('app.index.categories')

    @include('app.index.user_feedback')

    @include('app.index.promo_adventure_list')

    @include('app.index.promo_review_list')

    {{--@include('app.index.join_community')--}}

    @include('app.index.start_adventure')

@endsection

@section('app_scripts')
    <script src="{{ elixir('js/index.js') }}"></script>
@endsection

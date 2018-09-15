@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> > reviews
    <div class="pull-lg-right">
        <a href="{{ route('review_create') }}" class="btn btn-sm btn-success">Add Review</a>
    </div>
@stop

@section('content')

    @include('_partials.admin_flash')

    <table class="table table-striped table-hover" id="reviews">
        <tr class="thead-default">
            <th>ID</th>
            <th>Photo</th>
            <th>Place</th>
            <th>Title</th>
            <th>Description</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        @each('_partials.admin_review', $reviews, 'review')
    </table>

    @if ($reviews->lastPage() > 1)
    <table id="template_review_row">
        @include('_partials.admin_review', ['js' => 0, 'review' => new \App\Models\Reviews\Review()])
    </table>
    @endif

    @include('_partials.pagination', ['paginator' => $reviews, 'pagination_id' => 'reviews',
    'stats_id' => 'reviews_stats'])

@stop
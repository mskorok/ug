@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> > Adventures
    <div class="pull-lg-right">
        <a href="{{ route('adventure_create') }}" class="btn btn-sm btn-success">Add adventure</a>
    </div>
@stop

@section('content')

    @include('_partials.admin_flash')

    <table class="table table-striped table-hover" id="adventures">
        <tr class="thead-default">
            <th>ID</th>
            <th>Photo</th>
            <th>Place</th>
            <th>Title</th>
            <th>Description</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        @each('_partials.admin_adventure', $adventures, 'adventure')
    </table>

    @if ($adventures->lastPage() > 1)
    <table id="template_adventure_row">
        @include('_partials.admin_adventure', ['js' => 0, 'adventure' => new \App\Models\Adventures\Adventure()])
    </table>
    @endif

    @include('_partials.pagination', ['paginator' => $adventures, 'pagination_id' => 'adventures',
    'stats_id' => 'adventures_stats'])

@stop
@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> > Countries
    <div class="pull-lg-right">
        <a href="{{ url('/admin/countries/add') }}" class="btn btn-sm btn-success">Add country</a>
    </div>
@endsection

@section('content')
    @include('_partials.admin_flash')
    <table class="table table-striped table-hover">
        <tr class="thead-default">
            <th>ID</th>
            <th>ISO alpha 2</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        @each('_partials.geo.admin_country', $countries, 'country')
    </table>

    @include('_partials.pagination', ['paginator' => $countries, 'pagination_id' => 'countries',
    'stats_id' => 'countries_stats'])
@endsection

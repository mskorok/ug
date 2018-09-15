@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> > Users
    <div class="pull-lg-right">
        <a href="{{ url('/admin/users/add') }}" class="btn btn-sm btn-success">Add user</a>
    </div>
@stop

@section('content')

    @include('_partials.admin_flash')

    <table class="table table-striped table-hover" id="users">
        <tr class="thead-default">
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Registration date</th>
            <th>Last login date</th>
            <th>Actions</th>
        </tr>
        @each('_partials.admin_user', $users, 'user')
    </table>

    @if ($users->lastPage() > 1)
    <table id="template_user_row">
        @include('_partials.admin_user', ['js' => 0, 'user' => new \App\Models\Users\User()])
    </table>
    @endif

    @include('_partials.pagination', ['paginator' => $users, 'pagination_id' => 'users',
    'stats_id' => 'users_stats'])

@stop

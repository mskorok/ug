@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a>
@stop

@section('content')
    <div class="container">
        @include('_partials.admin_flash')
        <div class="hidden-xs-up p-x-3 p-y-1 m-b-2" id="create_interest_result"></div>
        <form id="interest_form">
            <fieldset class="form-group">
                <input type="text" class="form-control"  name="autocomplete"  id="autocomplete" >
                <label class="col-form-label"  for="autocomplete">Interests</label>
            </fieldset>
            <button type="button" id="create_interest" class="btn btn-primary">Create interest</button>
            <button id="edit_interest" class="btn btn-success m-l-3">Edit interest</button>
            <button id="delete_interest" class="btn btn-danger m-l-3">Delete interest</button>
        </form>
    </div>
    <script>
        var current_user = 4;
    </script>
@stop
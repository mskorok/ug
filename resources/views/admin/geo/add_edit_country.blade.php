@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> > <a href="{{url('/admin/countries')}}">Countries</a> > {{ $country->id ?? 'Create new country' }}
@stop

@section('content')
    <div class="container">

            <form role="form" method="POST" action="{{ url('/admin/countries/' . $country->id . (($action === 'add') ? 'add' : '') ) }}">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-sm-6">
                        @include(
                            '_partials.bs4.input',
                            [
                                'input' => 'iso_alpha2',
                                'label' => 'ISO alpha 2',
                                'value' => $country->iso_alpha2
                            ]
                        )
                    </div>
                    <div class="col-sm-6">
                        @include('_partials.bs4.input', ['input' => 'name', 'label' => 'Name', 'value' => $country->name])
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            @if ($action === 'add')
                                Create new country
                            @elseif ($action === 'edit')
                                Edit country
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@stop

@extends('app._layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('routes.about')}}</div>

                <div class="panel-body">
                    {{trans('routes.about')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

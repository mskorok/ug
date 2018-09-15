@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> > <a href="{{url('/admin/adventures')}}">Adventures</a> >&nbsp;&nbsp;{{$adventure->id}}
@stop
@section('content')
    <div class="container">
        <div class="h1 text-md-center">
            {{ $adventure->title }}
        </div>
        <div class="clearfix">
            <img av="src:promo_image" align="bottom" src="{{ $adventure->promo_image }}" alt="Profile photo" class="col-md-10  center-block">
        </div>

        <div class="text-md-center text-muted">
            {{ $adventure->short_description }}
        </div>
        <div class="small text-xs-center text-muted ">
            {{ $adventure->description }}
        </div>
    </div>
@stop
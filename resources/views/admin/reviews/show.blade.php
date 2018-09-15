@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> > <a href="{{url('/admin/reviews')}}">reviews</a> >&nbsp;&nbsp;{{$review->id}}
@stop
@section('content')
    <div class="container">
        <div class="h1 text-md-center">
            {{ $review->title }}
        </div>
        <div class="clearfix">
            <img av="src:promo_image" align="bottom" src="{{ $review->promo_image }}" alt="Profile photo" class="col-md-10  center-block">
        </div>

        <div class="text-md-center text-muted">
            {{ $review->short_description }}
        </div>
        <div class="small text-xs-center text-muted ">
            {{ $review->description }}
        </div>
    </div>
@stop
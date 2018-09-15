@extends('_layouts.email')

@section('main')
    <h1>{{ trans('mail.invite') }}</h1>

    <p>
        Hi, {{$user->name}} invite you <br>
        <br>
        to join adventure
        <br>
        {{ $adventure->title }}
        <br>

    </p>

@endsection
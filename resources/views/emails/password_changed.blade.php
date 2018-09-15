@extends('_layouts.email')

@section('main')
    <h1>{{ trans('mail.password_changed') }}</h1>

    <p>
        Hi, {{$name}}<br>
        <br>
        Your password changed successfully.<br>
        <br>

    </p>

@endsection

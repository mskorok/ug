@extends('_layouts.email')

@section('main')
    <h1>Email confirmed</h1>

    <p>
        Hi, {{$name}}<br>
        <br>
        Your email address confirmed successfully.<br>
        <br>
        You can now create own activities or join existing ones.<br>
    </p>

@endsection

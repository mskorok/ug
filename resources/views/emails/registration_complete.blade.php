@extends('_layouts.email')

@section('main')
<h1>Thank you for registration</h1>

<p>
    Hi, {{$name}}<br>
    <br>
    Your account created successfully.<br>
    <br>
    Please click on the button below to confirm your e-mail address.<br>
</p>

<a href="{{$activation_link}}" class="email-button">Confirm my email</a>

@endsection

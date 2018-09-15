@extends('_layouts.html')

@section('body-class') app-auth app-auth-m-b app-gradient-green @endsection

@section('body')
    <nav class="app-auth-nav">
        <div class="row">
            <div class="col-md-6 app-auth-logo-col">
                <a href="{{ url('/') }}"><img src="/img/app/auth/logo.png" class="app-auth-logo" alt="Logo"></a>
            </div>
            <div class="col-md-6 app-auth-back-col">
                <a href="{{ url('/') }}">← Back to homepage</a>
            </div>
        </div>
    </nav>

    <header class="app-auth-header">
        <h1 id="auth_title" class="app-auth-title">Account activation failed.</h1>
        <h2>{{ $message }}</h2>
    </header>

    <main class="container-fluid app-auth-main">

    </main>

@endsection

@extends('admin._layouts.auth')

@section('content')
    <div class="container-fluid m-a-2" style="max-width: 400px">

        <div class="text-xs-center m-b-2">
        <img src="/svg/app_logo.svg" alt="{{ trans('core.project_name') }}">
        </div>

        <div class="card card-block app-card-trans">
            <h4 class="card-title">Admin Log in</h4>
            <form role="form" method="POST" action="{{ url('/admin/login') }}">
                {!! csrf_field() !!}
                <fieldset class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label class="col-form-label" for="email">Email address</label>
                    <input type="email" id="email" class="form-control {{ $errors->has('email') ? ' form-control-danger' : '' }}" name="email" value="{{ old('email') }}" autofocus>
                    @if ($errors->has('email'))
                        <small class="text-help">{{ $errors->first('email') }}</small>
                    @endif
                </fieldset>
                <fieldset class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label class="col-form-label" for="password">Password</label>
                    <input type="password" id="password" class="form-control {{ $errors->has('password') ? ' form-control-danger' : '' }}" name="password">
                    @if ($errors->has('password'))
                        <small class="text-help">{{ $errors->first('password') }}</small>
                    @endif
                </fieldset>
                <div class="checkbox">
                    <label style="margin-left: 0.7rem">
                        <input type="checkbox" name="remember" style="height: 1.2rem">
                        <span> Remember me</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Log in</button>
            </form>
        </div>

    </div>
@endsection

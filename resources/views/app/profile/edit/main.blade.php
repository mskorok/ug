
@extends('app.profile.edit._layouts.profile')

@section('javascript')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" property='stylesheet'>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
@endsection

@section('profile-right-block')

    @include('app.profile.edit.subnavbar')

    <section id="profile_settings" class="app-profile-section">
        @include('app.profile.edit.settings')
    </section>

    <section id="change_password" class="app-profile-section hidden-xs-up">
        @include('app.profile.edit.change_password')
    </section>

    <section id="deactivate_account" class="app-profile-section hidden-xs-up">
        @include('app.profile.edit.deactivate')
    </section>

    <section id="notifications" class="app-profile-section hidden-xs-up">
        @include('app.profile.edit.notifications')
    </section>

    <section id="blocked_users" class="app-profile-section hidden-xs-up">
        @include('app.profile.edit.blocked_users')
    </section>

@endsection

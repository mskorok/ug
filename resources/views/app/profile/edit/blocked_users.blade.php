<div class="p-a-2">

    @foreach($user->blockedUsers()->get() as $blockedUser)
        <form id="blocked_user_{{ $blockedUser->user()->first()->id }}" class="unblock-user-form">
            <div class="row app-profile-blocked-user-row">
                <div class="col-xs-2">
                    <div class="m-b-1 app-profile-photo app-center-block app-circle app-square-lg">
                        {{--<img alt="Profile photo" id="profile_photo" class="app-relative app-square-xl" src="{{ $blockedUser->user()->first()->getLgPhotoPath() }}">--}}
                        <img alt="Profile photo" id="profile_photo" class="app-profile-blocked-user-photo app-relative app-square-xl" src="{{ $blockedUser->user()->first()->photo_path }}">
                    </div>
                </div>

                <div class="app-card-b-shadow">
                    <div class="col-xs-8 app-text-xl app-vertical-middle">
                        {{ $blockedUser->user()->first()->getName() }}
                    </div>
                    <div class="col-xs-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="{{ $blockedUser->user()->first()->id }}">
                            {{--<strong><button class="app-link-green app-text-sm unblock app-vertical-middle">Unblock</button></strong>--}}
                            <button type="submit" class="btn-sm btn-link app-link-green"><strong>Unblock</strong></button>
                    </div>
                </div>
            </div>
        </form>
    @endforeach

</div>

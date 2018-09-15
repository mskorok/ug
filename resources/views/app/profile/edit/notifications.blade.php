<div class="p-a-2">

    <form id="profile_notifications_form" method="POST">

        {!! csrf_field() !!}

        <section id="email-notifications" class="app-card-b-shadow p-b-1">
            <h6 class="app-t-subtitle m-b-2">E-mail notifications</h6>

            @foreach(trans('models/email_notifications') as $id => $text)
                <div class="form-group row">
                    <div class="checkbox">
                        <label>
                            <div class="app-checkbox m-r-1 {{ in_array($id, $user->email_notifications_bit) ? 'checked' : '' }}"></div>
                            <input class="hidden-xs-up form-control" type="checkbox" name="email_notifications_bit[{{ $id }}]" {{ in_array($id, $user->email_notifications_bit) ? 'checked' : '' }}>
                            {{ $text }}
                        </label>
                    </div>
                </div>
            @endforeach

        </section>

        <section id="alert-notifications" class="p-t-2 p-b-1 app-card-b-shadow">
            <h6 class="app-t-subtitle m-b-2">Alert notifications</h6>

            @foreach(trans('models/alert_notifications') as $id => $text)

                <div class="form-group row">
                    <div class="checkbox">
                        <label>
                            <div class="app-checkbox m-r-1 {{ in_array($id, $user->alert_notifications_bit) ? 'checked' : '' }}"></div>
                            <input class="hidden-xs-up form-control" type="checkbox" name="alert_notifications_bit[{{ $id }}]" {{ in_array($id, $user->alert_notifications_bit) ? 'checked' : '' }}>
                            {{ $text }}
                        </label>
                    </div>
                </div>
            @endforeach

        </section>

        <div class="m-l-1 m-t-2 m-b-1 form-group row">
            <button id="btn_save_notifications" type="button" class="btn app-btn-apply">Save changes</button>
            <button id="btn_cancel_notifications" type="button" class="btn btn-link app-link-grey">Cancel changes</button>
        </div>

    </form>

</div>

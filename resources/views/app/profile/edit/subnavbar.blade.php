<div class="navbar navbar-light app-subnavbar">
    <ul class="nav navbar-nav">
        <li id="nav_settings" class="nav-item active">
            <a href="#" class="nav-link @if(Request::is('/edit-profile')) active @endif">Profile settings</a>
        </li>
        <li id="nav_notifications" class="nav-item">
            <a href="#" class="nav-link ">Notifications</a>
        </li>
        <li id="nav_blocked_users" class="nav-item">
            <a href="#" class="nav-link">Blocked users</a>
        </li>
    </ul>

    <div class="pull-xs-right">

        <div class="dropdown">
            <svg id="show_more" class="app-subnavbar-menu-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 21px; height: 7px; margin-top: 15px; margin-right: 8px" role="img">
                <use xlink:href="#svg__option-horizontal"></use>
            </svg>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="show_more">
                <a id="change_password" class="dropdown-item" href="#">Change password</a>
                @if($user->is_active)
                    <a id="deactivate_account" class="dropdown-item" href="#">Deactivate account</a>
                @endif
                <a id="change_email" class="dropdown-item" href="#">Change email</a>
            </div>
        </div>
    </div>
</div>
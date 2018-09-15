<div class="app-activity-flex">
    <div class="app-p-card app-relative app-activity-user">
        <a class="app-activity-link" href="{{ url('activities/' . $activity->id) }}">
            <img src="{{ $activity->user->photo_path }}" class="app-activity-user-avatar"
                 alt="Activity image">
            <div class="app-inline-block app-activity-user-name">
                {{ $activity->user->getName() }}
            </div>
        </a>
        <div class="dropdown app-absolute app-activity-share">
            <a class="dropdown-toggle app-dropdown-toggle-remove" data-toggle="dropdown">
                <svg class="app-activity-icon">
                    <use xlink:href="#svg__share_icon"></use>
                </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="https://www.facebook.com/sharer.php?u={{ Request::url() }}" class="dropdown-item">Facebook</a>
                <a href="https://twitter.com/home?status={{ Request::url() }}" class="dropdown-item">Twitter</a>
            </div>
        </div>
    </div>
    <div class="app-p-card  app-activity-info">
        <div>
            <a class="app-activity-link" href="{{ url('activities/' . $activity->id) }}">
                <h3 class="app-activity-info-title p-y-1">{{ $activity->title }}</h3>
                <div class="app-inline-block app-activity-info-place m-r-1">{{ $activity->place_name }}</div>
                <time class="app-activity-info-date">
                    {{ date('d.m.Y', strtotime($activity->datetime_from)) }}
                    @if ($activity->datetime_to)
                        &nbsp;&ndash;&nbsp;{{ date('d.m.Y', strtotime($activity->datetime_to)) }}
                    @endif
                </time>
            </a>
        </div>
    </div>
</div>
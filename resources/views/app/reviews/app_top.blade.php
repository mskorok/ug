<div class="app-open-review-flex">
    <div class="app-p-card app-relative app-open-review-user">
        <a class="app-review-link" href="{{ url('activities/' . $review->id) }}">
            <img src="{{ $review->user->photo_path }}" class="app-open-review-user-avatar"
                 alt="Activity image">
            <div class="app-inline-block app-open-review-user-name">
                {{ $review->user->getName() }}
            </div>
        </a>
        <div class="dropdown app-absolute app-open-review-share">
            <a class="dropdown-toggle app-dropdown-toggle-remove" data-toggle="dropdown">
                <svg class="app-open-review-icon">
                    <use xlink:href="#svg__share_icon"></use>
                </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a  href="https://www.facebook.com/sharer.php?u={{ Request::url() }}" class="dropdown-item">Facebook</a>
                <a href="https://twitter.com/home?status={{ Request::url() }}" class="dropdown-item">Twitter</a>
            </div>
        </div>
    </div>
    <div class="app-p-card  app-open-review-info">
        <div>
            <a class="app-open-review-link" href="{{ url('activities/' . $review->id) }}">
                <h3 class="app-open-review-info-title p-y-1">{{ $review->title }}</h3>
                <div class="app-inline-block app-open-review-info-place m-r-1">{{ $review->place_name }}</div>
                <time class="app-open-review-info-date">
                    {{ date('d.m.Y', strtotime($review->datetime_from)) }}
                    @if ($review->datetime_to)
                        &nbsp;&ndash;&nbsp;{{ date('d.m.Y', strtotime($review->datetime_to)) }}
                    @endif
                </time>
            </a>
        </div>
    </div>
</div>

<div class="app-adventure-block">
    <a href="{{ $adventure->getUrl() }}">
        <figure class="app-adventure-block-image" style="background-image: url('{{ $adventure->promo_image }}')">
            <time class="app-adventure-block-added">{{ $adventure->statsAddedAgo }}</time>
            <div class="app-adventure-block-interests">
                {{--@php($k = 0)--}}
                {{--@foreach($adventure->interests as $interest)--}}
                    {{--<a href="{{url('/interests/'.str_slug($interest->name))}}">#{{$interest->name}}</a>--}}
                    {{--@php($k++)--}}
                    {{--@if ($k === 2)--}}
                        {{--@break--}}
                    {{--@endif--}}
                {{--@endforeach--}}
            </div>
            <h3 class="app-adventure-block-title">{{ $adventure->title }}</h3>
        </figure>
    </a>

    <div class="app-relative">
        <a href="{{ $adventure->user->getProfileUrl() }}">
            <img src="{{ $adventure->user->getPhotoPath(APP_PHOTO_SMALL) }}" class="app-adventure-block-author-photo">
        </a>
    </div>

    <div class="app-adventure-block-main">
        <div class="app-adventure-block-location-container">
            <h4 class="app-adventure-block-location">{{ $adventure->place_name }}</h4>
            <div class="app-adventure-block-location-shadow"></div>
        </div>

        <time class="app-adventure-block-date">{{ date('d.m.Y', strtotime($adventure->datetime_from)) }}</time>

        <div class="app-adventure-block-desc-container">
            <p class="app-adventure-block-desc">{{ $adventure->short_description }}</p>
            <div class="app-adventure-block-desc-shadow"></div>
        </div>

        <div class="app-adventure-block-users-container">
            @if (!empty($adventure->going))
                @php($k = 0)
                @php($faker = new \App\Helpers\ImageFaker)
                @foreach ($adventure->going as $going_user_id)
                    @php($k++)
                    @if ($k <= 6)
                        <img src="{{ $faker->user() }}" alt="User">
                    @else
                        <div class="app-adventure-block-users-more">+{{ $adventure->getGoingCount() - 6 }}</div>
                        @break
                    @endif
                @endforeach
            @else
                <a href="{{ url('/register') }}" class="app-adventure-block-users-link">Be the first to join</a>
            @endif
        </div>

        <div class="app-adventure-block-footer app-comma-list-bullet">
            <span>{{ $adventure->statsGoing }}</span>
            <span>{{ $adventure->statsFollowing }}</span>
            <span>{{ $adventure->statsComments }}</span>
        </div>
    </div>

</div>

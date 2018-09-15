
<div class="m-b-2 app-follow">
    @if(count($matched) > 0)
        <div class="app-color-grey m-y-2 app-follow-title">People you might want to follow</div>
    @endif
    <div class="app-follow-blocks">
        {{--@foreach($matched as $item)--}}

        @for($i = 0; $i < count($matched); $i++)
            <div class="app-follow-matched-block app-follow-matched-block">
                <div>
                    <a  href="/users/{{ $matched[$i]->user_id }}">
                        <img src="{{ $matched[$i]->photo_path }}" class="app-follow-photo">
                    </a>
                </div>
                <a href="/users/{{ $matched[$i]->user_id }}">
                    <div class="app-color-green app-follow-user-name">
                        {{ $matched[$i]->getName() }}
                    </div>
                </a>
                <div class="app-color-grey app-text-xs">
                    {{ $matched[$i]->count }}  common interests
                </div>
            </div>
        @endfor
        {{--@endforeach--}}
        <div class="app-follow-shadow hidden-md-down"></div>
    </div>
</div>

<div class="row p-y-2">
    <div class="col-xs-12 col-lg-4">
        <a href="{{ $review->getUrl() }}">
            <img class="w-100" src="{{ $review->promo_image }}">
        </a>
    </div>
    <div class="col-xs-12 col-lg-8">
        <article class="app-review-block">

            <header class="app-review-block-header">
                @if(isset($recommendedUsers)  && is_array($recommendedUsers))
                    <div class="m-b-1">
                        <svg id="app_recommended" class="app-icon-md app-icon-stroke-gray  app-vertical-middle">
                            <use xlink:href="#svg__recommend"></use>
                        </svg>
                        <div class="app-inline-block m-l-1 app-text-xs app-color-grey">
                            Recommended by {{ $recommendedUsers[0]->getName() }} &nbsp;
                        </div>
                        @if(count($recommendedUsers) > 1)
                            <div class="dropdown app-inline-block app-text-xs app-color-grey ">
                                <a class="dropdown-toggle app-dropdown-toggle-remove" data-toggle="dropdown">
                                    and {{ count($recommendedUsers) }} others
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach($recommendedUsers as $item)
                                    <a href="/users/{{ $item->id }}" class="dropdown-item" target="_blank">
                                        <img src="{{$item->photo_path}}" class="app-review-block-recommended-image">
                                        <div class="app-inline-block app-text-xs app-color-grey m-l-1">
                                            {{ $item->getName() }}
                                        </div>

                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                <img class="app-review-block-photo" src="{{ $review->user->getPhotoPathAttribute() }}" alt="User's {{ $review->user->getName() }} photo">
                <div class="app-review-block-author">
                    <a href="{{ $review->user->getProfileUrl() }}">{{ $review->user->getName() }}</a>
                    <div class="app-review-block-stats">
                                <span>
                                    {{ $review->created_at->diffForHumans() }}
                                </span>
                        <span class="app-s-bullet"></span>
                                <span>
                                    {{ $review->lastRead() }}
                                </span>
                    </div>
                </div>
            </header>

            <h3 class="app-review-block-title">{{ $review->title }}</h3>

            <div class="app-review-block-location">
                        <span>
                            {{ $review->place_name }}
                        </span>
                <span class="app-s-bullet"></span>
                        <span>
                            {{ $review->created_at->format('d.m.Y') }}
                        </span>
            </div>

            <p class="app-review-block-desc">
                {{ $review->short_description }}
            </p>

            <footer class="app-review-block-footer">
                <div class="app-review-block-icon app-review-like"
                     @if(Auth::check() && !$review->isLiked(Auth::id()) && $review->user->id !== Auth::id()) data-like="{{ $review->id }}"  @endif>
                    <svg class="app-icon-stroke @if(Auth::check() && ($review->isLiked(Auth::id()))) active @endif "
                         @if(Auth::check() && !$review->isLiked(Auth::id()) && $review->user->id !== Auth::id()) role="button" @endif>
                        <use xlink:href="#svg__article__heart"></use>
                    </svg>
                    <span class="app-review-like-data"  data-like="{{ $review->id }}">{{ $review->like_count ?? 0 }}</span>
                </div>
                <div class="app-review-block-icon">
                    <svg class="app-icon-stroke">
                        <use xlink:href="#svg__article__comment"></use>
                    </svg>
                    <span>{{ $review->getCommentsCount() }}</span>
                </div>
            </footer>
        </article>
    </div>
</div>
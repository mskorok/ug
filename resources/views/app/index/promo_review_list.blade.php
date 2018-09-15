
<section class="app-section">

    <h2 class="app-title app-index-title">{{ trans('app/index.review_title') }}</h2>

    <h4 class="app-subtitle app-index-subtitle">{{ trans('app/index.review_desc') }}</h4>

    <div class="app-container-1600">
            @php($k = 0)
        @foreach($reviews as $review)
            @if ($k === 0)
                <div class="row">
            @endif
            <div class="col-xl-4">

                <article class="app-promo-review">

                    <header class="app-promo-review-header">
                        <a href="{{ $review->user->getProfileUrl() }}">
                            <img class="app-promo-review-photo" src="{{ $review->user->getPhotoPathAttribute() }}" alt="User's {{ $review->user->getName() }} photo">
                        </a>
                        <div class="app-promo-review-author">
                            <a href="{{ $review->user->getProfileUrl() }}">{{ $review->user->getName() }}</a>
                            <div class="app-promo-review-stats">
                                <span>
                                    {{ $review->statsAddedAgo }}
                                </span>
                                <span class="app-s-bullet"></span>
                                <span>
                                    {{ $review->statsReadTime }}
                                </span>
                            </div>
                        </div>
                    </header>

                    <a href="{{ $review->getUrl() }}">
                        <h3 class="app-promo-review-title">{{ $review->title }}</h3>

                        <div class="app-promo-review-location">
                        <span>
                            {{ $review->place_name }}
                        </span>
                            <span class="app-s-bullet"></span>
                        <span>
                            {{ $review->created_at->format('d.m.Y') }}
                        </span>
                        </div>

                        <p class="app-promo-review-desc">
                            {{ $review->short_description }}
                        </p>

                        <footer class="app-promo-review-footer">
                            <div class="app-promo-review-icon">
                                <svg class="app-icon-stroke">
                                    <use xlink:href="#svg__article__heart"></use>
                                </svg>
                                <span>90</span>
                            </div>
                            <div class="app-promo-review-icon">
                                <svg class="app-icon-stroke">
                                    <use xlink:href="#svg__article__comment"></use>
                                </svg>
                                <span>90</span>
                            </div>

                        </footer>
                    </a>

                </article>


            </div>

            @if ($k === 2)
                </div>
            @endif

            @php(($k >= 2) ? $k = 0 : $k++)

        @endforeach

        <a href="{{url('/reviews')}}" class="app-index-browse-link">{{ trans('app/index.review_browse_all') }}</a>

    </div>

</section>

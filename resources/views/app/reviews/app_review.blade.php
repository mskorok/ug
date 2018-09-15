@extends('app._layouts.app')

@section('meta')
    <meta property="og:url" content="{{ Request::url() }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $review->title }}"/>
    <meta property="og:description" content="{{ $review->short_description }}"/>
    <meta property="og:image" content="{{ $review->promo_image }}"/>
@endsection

@section('content')
    <section class="hidden-lg-up">
        <figure class="app-p-card app-open-review-block-image"
                style="background-image: url('{{ $review->promo_image }}')">
        </figure>
    </section>
    <section class="app-open-review" data-review="{{ $review->id }}">
        <div class="row">
            <div class="col-xs-12  col-lg-8">
                <div class="app-card">
                    <figure class="app-p-card app-open-review-block-image hidden-md-down"
                            style="background-image: url('{{ $review->promo_image }}')">
                        @include('app.reviews.app_top', ['review' => $review])
                    </figure>
                    <div class="row m-x-0 hidden-lg-up app-p-card">
                        <div class="col-lg-12">
                            @include('app.reviews.app_top', ['review' => $review])
                        </div>
                    </div>

                    <div class="row m-x-0 app-p-card">
                        <div class="col-xs-12">{!! $review->description !!}</div>
                        <div class="col-xs-12">
                            @include('app._partials.gallery', ['gallery' => json_decode($review->gallery)])
                        </div>
                        <div class="col-xs-12 m-y-2">
                            @foreach($review->interests as $interest)
                                <button class="app-tag">{{ $interest->name }}</button>
                            @endforeach
                        </div>


                        <div class="col-xs-12 col-lg-6">
                            <div class="app-inline-block app-review-like app-vertical-middle"
                                 @if(Auth::check() && !$review->isLiked(Auth::id()) && $review->user->id !== Auth::id()) data-like="{{ $review->id }}" @endif>
                                <svg class="app-icon-stroke @if(Auth::check() && ($review->isLiked(Auth::id()))) active @endif "
                                     @if(Auth::check() && !$review->isLiked(Auth::id()) && $review->user->id !== Auth::id()) role="button" @endif>
                                    <use xlink:href="#svg__article__heart"></use>
                                </svg>
                                <span class="app-color-grey app-review-like-data app-open-review-post-count"
                                      data-like="{{ $review->id }}">{{ $review->like_count ?? 0 }}</span>
                            </div>

                            <div class="app-inline-block app-vertical-middle">
                                <svg class="app-icon-stroke">
                                    <use xlink:href="#svg__article__comment"></use>
                                </svg>
                                <span class="app-color-grey app-open-review-post-count">{{ $review->getCommentsCount() }}</span>
                            </div>


                            <div class="dropdown app-inline-block pull-xs-right m-r-1 hidden-lg-up">
                                <a class="dropdown-toggle app-dropdown-toggle-remove" data-toggle="dropdown">
                                    <svg class="m-l-1 app-icon-xl app-icon-gray app-vertical-middle">
                                        <use xlink:href="#svg__option-horizontal"></use>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <a href="https://www.facebook.com/sharer.php?u={{ Request::url() }}"
                                       class="dropdown-item">
                                        <svg class="app-icon-xl app-icon-gray">
                                            <use xlink:href="#svg__share_icon"></use>
                                        </svg>
                                        <span class="m-l-1">Share Facebook</span>
                                    </a>
                                    <a href="https://twitter.com/home?status={{ Request::url() }}"
                                       class="dropdown-item">
                                        <svg class="app-icon-xl app-icon-gray">
                                            <use xlink:href="#svg__share_icon"></use>
                                        </svg>
                                        <span class="m-l-1">Share Twitter</span>
                                    </a>

                                    <div class="dropdown-item">
                                        <svg id="app_recommended_mobile"
                                             class="app-open-review-recommend app-icon-xl app-icon-stroke-gray  app-vertical-middle @if(Auth::check() && $review->isRecommended(Auth::id()) && $review->user->id !== Auth::id()) active @endif"
                                             @if(Auth::check() && !$review->isRecommended(Auth::id()) && $review->user->id !== Auth::id()) role="button" @endif>
                                            <use xlink:href="#svg__recommend"></use>
                                        </svg>
                                        <span class="m-l-1">Recommend</span>
                                    </div>
                                    <a href="#" class="dropdown-item">Edit</a>
                                    <a href="#" class="dropdown-item">Delete</a>
                                </div>
                            </div>

                        </div>


                        <div class="col-xs-12 col-lg-6 hidden-md-down">
                            <div class="dropdown app-inline-block pull-xs-right m-r-1">
                                <span class="m-l-1 app-color-grey">More</span>
                                <a class="dropdown-toggle app-dropdown-toggle-remove" data-toggle="dropdown">
                                    <svg class="m-l-1 app-icon-xl app-icon-gray app-vertical-middle">
                                        <use xlink:href="#svg__option-horizontal"></use>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item">Edit</a>
                                    <a href="#" class="dropdown-item">Delete</a>
                                </div>
                            </div>
                            <div class="app-inline-block pull-xs-right m-x-1">
                                <svg id="app_recommended"
                                     class="app-open-review-recommend app-icon-xl app-icon-stroke-gray  app-vertical-middle @if(Auth::check() && $review->isRecommended(Auth::id()) && $review->user->id !== Auth::id()) active @endif"
                                     @if(Auth::check() && !$review->isRecommended(Auth::id()) && $review->user->id !== Auth::id()) role="button" @endif>
                                    <use xlink:href="#svg__recommend"></use>
                                </svg>
                            </div>
                            <div class="dropdown app-inline-block pull-xs-right">
                                <a class="dropdown-toggle app-dropdown-toggle-remove" data-toggle="dropdown">
                                    <svg class="app-icon-xl app-icon-gray">
                                        <use xlink:href="#svg__share_icon"></use>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="https://www.facebook.com/sharer.php?u={{ Request::url() }}"
                                       class="dropdown-item">Facebook</a>
                                    <a href="https://twitter.com/home?status={{ Request::url() }}"
                                       class="dropdown-item">Twitter</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div>
                    @if (Auth::check())
                        <div class="app-color-grey app-activity-block-title">New post</div>
                        <div class="app-card app-p-card">
                            <div class="row">
                                <div class="pull-xs-left app-activity-new-post">
                                    <img class="app-activity-user-avatar m-r-2" src="{{ Auth::user()->photo_path }}"
                                         alt="User avatar"/>
                                </div>
                                <div class="pull-xs-left">
                                    <form id="app_review_create_reply" class="app-open-review-response-form"
                                          enctype="multipart/form-data" method="post">
                                        <div class="row form-group m-b-0">
                                        <textarea id="app_activity_create_new_post"
                                                  class="form-control app-activity-textarea"
                                                  rows="2" name="text" placeholder="Write something ..."
                                                  maxlength="255">
                                        </textarea>
                                            <input type="hidden" name="parent_id" value="">
                                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                                            <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($review->getCommentsCount() > 0)
                        <div class="app-open-review-block-title">
                            <div class="app-color-grey">There are others responses</div>
                            <button id="app_review_show_more_comments"
                                    class="btn btn-sm app-btn-outline-apply m-t-1">
                                Show more
                            </button>
                        </div>
                        <div class="app-color-grey app-open-review-block-title hidden-xs-up">Recent posts</div>
                    @endif
                    <div id="app_review_post_container" class="hidden-xs-up">
                        @foreach($review->comments()->whereNull('parent_id')->getResults() as $post)
                            <div class="m-b-2">
                                <div class="row app-card app-p-card m-x-0" data-post="{{ $post->id }}">
                                    @include('app.reviews.post_block', ['post' => $post])
                                </div>
                                <div class="row app-card m-x-0 app-p-card app-open-review-m-t-quarter @if(count($post->responses) == 0) hidden-xs-up @endif">
                                    <div class="row  app-relative app-responses-title">
                                        <div class="col-xs-12 app-color-grey">Responses</div>
                                        @if(Auth::check() && ($review->user->id === Auth::id() || $is_admin))
                                            <div class="dropdown app-absolute app-absolute-right-block p-r-2">
                                                <a class="dropdown-toggle app-dropdown-toggle-remove"
                                                   data-toggle="dropdown">
                                                    <svg class="app-icon app-icon-gray pull-xs-right">
                                                        <use xlink:href="#svg__option-horizontal"></use>
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item app-delete-comment"
                                                       data-comment="{{ $post->id }}">Delete comment</a>
                                                    <a href="#" class="dropdown-item app-block-user" data-owner="{{ $review->user->id }}" data-blocked="{{ $post->user->id }}">Block user</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row app-p-card app-responses-block">
                                        @if(count($post->responses) > 0)
                                            @foreach($post->responses as $response)
                                                <div class="col-xs-12 p-t-2 app-card-b-divider">
                                                    @include('app.reviews.post_block', ['post' => $response])
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-4 app-card-t-divider">
                @if($activityRelated instanceof \App\Models\Adventures\Adventure)
                    <div class="app-color-grey app-activity-block-title">Related activities</div>
                    @include('app._partials.adventure_block', ['adventure' => $activityRelated])
                @endif
            </div>
        </div>
    </section>
    <section>
        <div class="row app-section">
            <div class="col-xs-12">
                <div class="app-color-grey m-l-1">Related reviews</div>
                <div>
                    @if($recommended instanceof \App\Models\Reviews\Review)
                        @include('app._partials.review_block', ['review' => $recommended, 'recommendedUsers'  => $recommendation])
                    @endif
                </div>
                <div class="app-card-b-divider"></div>
                <div>
                    @include('app._partials.follow', ['matched' => $matched])
                </div>
                <div id="app_review_rows">
                    @include('app._partials.reviews_row', ['reviews' => $reviewRelated])
                </div>
                @if ($showMore)
                    <div class="app-open-review-load-section">
                        <button id="app_button_more" class="btn btn-block app-btn-apply app-border-radius-4">
                            <span id="app_reviews_more_text">More</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

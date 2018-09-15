@extends('app._layouts.app')
@section('meta')
    <meta property="og:url" content="{{ Request::url() }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $activity->title }}"/>
    <meta property="og:description" content="{{ $activity->short_description }}"/>
    <meta property="og:image" content="{{ $activity->promo_image }}"/>
@endsection
@section('content')
    <section class="hidden-lg-up">
        <figure class="app-p-card app-activity-block-image"
                style="background-image: url('{{ $activity->promo_image }}')">
        </figure>
    </section>
    <section class="app-activity" data-adventure="{{ $activity->id }}">
        <div class="row m-b-1">
            <div class="col-xs-12  col-lg-8">
                <div class="app-card">
                    <figure class="app-activity-block-image hidden-md-down"
                            style="background-image: url('{{ $activity->promo_image }}')">
                        @include('app.activities.app_top', ['activity' => $activity])
                    </figure>
                    <div class="row m-x-0 hidden-lg-up app-p-card">
                        <div class="col-lg-12">
                            @include('app.activities.app_top', ['activity' => $activity])
                        </div>
                    </div>
                    <div class="row m-x-0 app-p-card">
                        <div class="col-xs-12 col-lg-6 p-l-0 p-b-1">{{ $activity->short_description }}</div>
                        <div class="col-xs-12 col-lg-6 p-l-0">
                            @if($activity->user->id === Auth::id() || $is_admin)
                                <button class="btn btn-sm app-btn-outline-apply app-activity-btn-outline pull-lg-right dropdown">
                                    <a class="dropdown-toggle app-dropdown-toggle-remove" data-toggle="dropdown">
                                        <svg class="app-icon-md app-icon-green app-vertical-middle">
                                            <use xlink:href="#svg__note"></use>
                                        </svg>
                                        <span class="m-l-1">More options</span>
                                        <svg class="m-l-1 app-icon-md app-icon-gray app-vertical-middle">
                                            <use xlink:href="#svg__option-horizontal"></use>
                                        </svg>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            {{--<a href="{{ route('activity_edit') }}" class="dropdown-item">Edit</a>--}}
                                            {{--<a href="{{ route('activity_delete') }}" class="dropdown-item">Delete</a>--}}
                                            <a href="#" class="dropdown-item">Edit</a>
                                            <a href="#" class="dropdown-item">Delete</a>
                                        </div>
                                    </a>
                                </button>
                            @else
                                <a href="{{ url('/register') }}">
                                    <button id="app_activity_interested"
                                            class="btn btn-sm app-btn-outline-apply m-r-1 m-b-1 app-activity-btn">
                                        Follow
                                    </button>
                                </a>
                                <a href="{{ url('/register') }}">
                                    <button id="app_activity_join"
                                            class="btn btn-sm app-btn-apply m-b-1 app-activity-btn">
                                        Participate
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-4">
                <div class="app-card app-p-card">
                    <div class="p-b-2 app-card-b-divider app-color-grey">
                        <span id="app_activity_going">{{ $goingCount }}</span> Going
                        @if ($activity->going)
                            <div class="p-t-1">
                                @for ($i = 0; $i < min(5, $goingCount); $i++)
                                    <img src="{{ $faker->user() }}" class="app-activity-going-image app-circle" alt="User">
                                @endfor
                                @if($goingCount > 5)
                                    <div class="app-inline-block app-adventure-block-users-more">
                                        +{{ $goingCount - 5 }}</div>
                                @endif
                            </div>
                        @else
                            <a href="" class="app-adventure-block-users-link app-block">Be the first to join</a>
                        @endif
                    </div>
                    <div class="m-t-1 app-color-grey">
                        <span id="app_activity_interested">{{ $followingCount }}</span> Interested
                        @if ($activity->following)
                            <div class="p-t-1">
                                @for ($i = 0; $i < min(5, $followingCount); $i++)
                                    <img src="{{ $faker->user() }}" class="app-activity-going-image app-circle" alt="User">
                                @endfor
                                @if($followingCount > 5)
                                    <div class="app-inline-block app-adventure-block-users-more">
                                        +{{ $followingCount - 5 }}</div>
                                @endif
                            </div>
                        @else
                            <a href="" class="app-adventure-block-users-link app-block">Be the first to join</a>
                        @endif
                    </div>
                </div>
                @if(Auth::check() && ($activity->user->id === Auth::id() || $is_admin))
                    <div class="app-card app-activity-m-t-quarter">
                        <div class="app-p-card p-b-0">
                            <div class="app-color-grey">
                                Invite new friends
                                <button class="app-btn-reset pull-xs-right">
                                    <span class="app-s-close app-color-grey-dark"></span>
                                </button>

                            </div>
                            <div class="navbar navbar-light p-x-0 app-new-activities-form-menu">
                                <ul class="nav navbar-nav app-flex-middle app-flex-stretch">
                                    <li class="nav-item active app-white-space-nowrap">
                                        <a class="nav-link p-l-0" href="#">Select friends</a>
                                    </li>
                                    <li class="nav-item app-white-space-nowrap app-card-b-divider">
                                        <a class="nav-link p-r-0" href="#">Invite via mail</a>
                                    </li>
                                    <li class="nav-item w-100 app-card-b-divider"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="app-relative app-block app-shadow-none app-border-none w-100  app-activity-friends">
                                <div class="app-activity-scroll">
                                    <form name="activity_invited" id="activities_invited">
                                        @for ($i = 0; $i < 10; $i++)
                                            @php($j = mt_rand(0,1))
                                            @php($id = mt_rand(1,500))
                                            @php($checked = ($j == 1) ? 'checked' : '')

                                            <div class="dropdown-item app-dropdown-item-checkbox app-white-space-nowrap">
                                                <label class="btn-block app-checkbox-label">
                                                    <div class="app-checkbox {{ $checked }}"></div>
                                                    <img src="{{ $faker->user() }}"
                                                         class="m-l-1 app-activity-going-image app-circle" alt="User">
                                                    <input class="hidden-xs-up" name="invited[{{ $id }}]"
                                                           type="checkbox" {{ $checked }} >
                                                    <span>{{ $nameFaker->firstName }}  {{ $nameFaker->lastName }}</span>
                                                </label>
                                            </div>
                                        @endfor
                                    </form>
                                    <div class="app-activity-white-space w-100"></div>
                                </div>
                                <div class="app-activity-block-invite-shadow"></div>
                            </div>
                        </div>
                        <div class="app-card-b-divider m-x-1"></div>
                        <div class="app-p-card">
                            <button id="activity_invited_submit_button" class="btn app-btn-outline-apply">
                                Invite selected people
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-8">
                <div class="app-card">
                    <div class="app-p-card app-card-b-divider">
                        <div class="row p-b-1">
                            <div class="col-xs-8">
                                <svg class="app-icon app-icon-green m-r-1">
                                    <use xlink:href="#svg__location"></use>
                                </svg>
                                <span class="app-color-grey">{{ $activity->place_name }}</span>
                            </div>
                            <div class="col-xs-4 text-xs-right hidden-xs-up">
                                <a href="#" class="app-activity-link-post">Show map</a>
                            </div>
                        </div>
                        <div class="row p-b-1">
                            <div class="col-xs-12">
                                <svg class="app-icon app-icon-green m-r-1">
                                    <use xlink:href="#svg__calendar"></use>
                                </svg>
                                <time class="app-color-grey">{{ date('d.m.Y', strtotime($activity->datetime_from)) }}
                                    @if ($activity->datetime_to)
                                        &nbsp;&ndash;&nbsp;{{ date('d.m.Y', strtotime($activity->datetime_to)) }}
                                    @endif
                                </time>
                            </div>
                        </div>
                    </div>
                    <div class="app-p-card">
                        {!! $activity->description !!}
                    </div>
                </div>
                <div>
                    @if (Auth::check())
                        <div class="app-color-grey app-activity-block-title">New post</div>
                        <div class="app-card app-p-card">
                            <div class="row">
                                <div class="pull-xs-left app-activity-new-post">
                                    <img class="app-activity-user-avatar app-circle m-r-2" src="{{ Auth::user()->photo_path }}"
                                         alt="User avatar"/>
                                </div>
                                <div class="pull-xs-left">
                                    <form id="app_activity_create_reply" class="app-activity-response-form"
                                          enctype="multipart/form-data" method="post">
                                        <div class="row form-group m-b-0">
                                        <textarea id="app_activity_create_new_post"
                                                  class="form-control app-activity-textarea"
                                                  rows="2" name="text" placeholder="Write something ..."
                                                  maxlength="255">
                                        </textarea>
                                            <input type="hidden" name="parent_id" value="">
                                            <input type="hidden" name="adventure_id" value="{{ $activity->id }}">
                                            <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if($activity->getCommentsCount() > 0)
                            <div class="app-color-grey app-activity-block-title">Recent posts</div>
                        @endif
                        <div id="app_activity_post_container">
                            @foreach($activity->comments()->whereNull('parent_id')->getResults() as $post)
                                <div class="m-b-2">
                                    <div class="row app-card app-p-card m-x-0" data-post="{{ $post->id }}">
                                        @include('app.activities.post_block', ['post' => $post])
                                    </div>
                                    <div class="row app-card m-x-0 app-p-card app-activity-m-t-quarter @if(count($post->responses) == 0) hidden-xs-up @endif">
                                        <div class="row  app-relative app-responses-title">
                                            <div class="col-xs-12 app-color-grey">Responses</div>
                                            @if(Auth::check() && ($activity->user->id === Auth::id() || $is_admin))
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
                                                        <a href="#" class="dropdown-item app-block-user"
                                                           data-owner="{{ $activity->user->id }}"
                                                           data-blocked="{{ $post->user->id }}">Block user</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row app-p-card app-responses-block">
                                            @if(count($post->responses) > 0)
                                                @foreach($post->responses as $response)
                                                    <div class="col-xs-12 p-t-2 app-card-b-divider">
                                                        @include('app.activities.post_block', ['post' => $response])
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="app-color-grey app-activity-block-title">Please <a href="{{ url('/login') }}">log
                                in</a> or <a href="{{ url('/register') }}">register</a> to view comments
                        </div>
                    @endif
                </div>

                @if(Auth::check() && ($activity->user->id === Auth::id() || $is_admin))
                    <div class="app-card app-p-card m-t-1">
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="interests_hidden_block"></div>
                                <div id="interests_for_creation"></div>
                            </div>
                            <div class="col-xs-12">
                                <div id="interests" class="app-p-card"></div>
                            </div>
                        </div>
                        <div class="hidden-xs-up p-x-3 p-y-1 m-b-2" id="create_interest_result"></div>
                        <div class="form-group row">
                            <div class="form-group">
                                <label class="col-xs-12 col-lg-4 col-xl-3 p-l-1 col-form-label app-line-height"
                                       for="activity_interest_autocomplete">
                                    This activity is all about
                                </label>
                                <div class="col-xs-12 col-lg-8 col-xl-9 p-r-1 form-group">
                                    <div id="activity_interest_autocomplete_autocomplete" class="app-relative dropdown">
                                        <input id="activity_interest_autocomplete" class="form-control" type="text"
                                               name="autocomplete" placeholder="Type your interest keyword">
                                        {{--<input id="add_interest_to_activity" type="button" value="Add"--}}
                                        {{--class="app-btn-in-input">--}}
                                        <input type="hidden" id="new_activity_interest_autocomplete_hidden"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @if($activity->interests->count() > 0)
                        <div class="app-card app-p-card m-t-1">
                            <div class="row">
                                <div class="col-xs-12">
                                    @foreach($activity->interests as $interest)
                                        <button class="app-tag">{{ $interest->name }}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

            </div>
            <div class="col-xs-12 col-lg-4">
                @if(Auth::check() && ($activity->user->id === Auth::id() || $is_admin))
                    <div class="app-color-grey app-activity-block-title">Related activities</div>
                    @if($activityRelated instanceof \App\Models\Adventures\Adventure)
                        @include('app._partials.adventure_block', ['adventure' => $activityRelated])
                    @endif
                @endif
            </div>
        </div>
    </section>
@endsection

<div class="row">
    <div class="col-xs-12">
        <img src="{{ $post->user->photo_path }}" class="pull-xs-left app-activity-user-avatar"
             alt="User avatar"/>
        <div class="col-xs-6">
            <div class="app-color-green">
                {{ $post->user->getName() }}
            </div>
            <div class="app-color-grey app-text-xs">
                {{ $post->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
<div class="row p-y-2">
    <div class="col-xs-12">
        {{ $post->text }}
    </div>
</div>
<div class="@if($post->parent_id)row p-b-1 @else row  @endif">
    <div class="pull-xs-left app-activity-new-post">
        <span class="app-activity-post-like app-activity-link"
           @if(Auth::check() && !$post->isLiked(Auth::id()) && $post->user->id !== Auth::id())
           data-like="{{ $post->id }}" @endif>
            <svg class="app-vertical-middle app-icon-stroke @if(Auth::check() && ($post->isLiked(Auth::id()))) active @endif"
            @if(Auth::check() && !$post->isLiked(Auth::id()) && $post->user->id !== Auth::id())
            role="button"
            @endif>
                <use xlink:href="#svg__article__heart"></use>
            </svg>
        </span>
            <span class="app-activity-post-like-data app-activity-post-count app-color-grey-dark"
                  data-like="{{ $post->id }}">
                {{ $post->like_count }}
            </span>
        @if(!$post->parent_id)
            <span class="app-activity-reply app-activity-link"
               @if(Auth::check())
               data-reply="{{ $post->id }}" @endif>
                <svg class="app-vertical-middle app-icon-stroke" @if(Auth::check()) role="button"  @endif>
                    <use xlink:href="#svg__article__comment"></use>
                </svg>
            </span>
            <span class="app-activity-reply-data app-activity-post-count app-color-grey-dark"
                  data-reply="{{ $post->id }}">
                {{ $post->reply_count }}
            </span>
        @endif
    </div>
    <div class="pull-xs-left hidden-xs-up">
        @if(!$post->parent_id)
            <form class="app-activity-response-form app-activity-reply-form" enctype="multipart/form-data"
                  data-form={{ $post->id }} method="post">
                <div class="row form-group m-x-0">
                                    <textarea class="form-control app-activity-textarea"
                                              rows="2" name="text" placeholder="Write something ..." maxlength="255">
                                    </textarea>
                    <input type="hidden" name="parent_id" value="{{ $post->id }}">
                    <input type="hidden" name="adventure_id" value="{{ $activity->id }}">
                    <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                </div>
            </form>
        @endif
    </div>
</div>


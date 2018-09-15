<div class="row  app-relative app-responses-title">
    <div class="col-xs-12  app-color-grey">Responses</div>
    <div class="dropdown app-absolute  app-absolute-right-block p-r-2">
        <a class="dropdown-toggle app-dropdown-toggle-remove" data-toggle="dropdown">
            <svg class="app-icon app-icon-gray pull-xs-right">
                <use xlink:href="#svg__option-horizontal"></use>
            </svg>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="#" class="dropdown-item app-delete-comment" data-comment="{{ $comment->id }}">Delete comment</a>
            <a href="#" class="dropdown-item app-block-user" data-owner="{{ $model->user->id ?? 'null' }}"  data-blocked="{{ $comment->user->id }}">Block user</a></div>
    </div>
</div>
<div class="row app-p-card app-responses-block"></div>
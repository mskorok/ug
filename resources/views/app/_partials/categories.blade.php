<ul class="nav navbar-nav pull-xs-right hidden-md-down app-dropdown">

    <form name="categories" id="categories_form" class="app-inline-block" action="" method="GET">
        <li class="nav-item dropdown">
            <button class="nav-link app-btn-reset dropdown-toggle" type="button" role="button" data-toggle="dropdown" data-close-inside="false" aria-haspopup="true" aria-expanded="false">All categories</button>
            <ul class="dropdown-menu dropdown-menu-right">
                @foreach ($categories as $id => $category)
                    <ul class="dropdown-item app-dropdown-item-checkbox">
                        <label class="btn-block app-checkbox-label">
                            <div class="app-checkbox {{ $category['checked'] }}"></div>
                            <input class="hidden-xs-up" name="categories[{{ $id }}]" type="checkbox" {{ $category['checked'] ? 'checked' : '' }} >
                            <span>{{ $category['name'] }}</span>
                        </label>
                    </ul>
                @endforeach
                <li class="dropdown-item">
                    <button type="submit" class="btn app-btn-apply btn-block btn-sm app-border-radius-4">Apply filter</button>
                </li>
            </ul>
        </li>
        <input type="hidden" id="tab" name="tab" value="people_new">
    </form>

</ul>

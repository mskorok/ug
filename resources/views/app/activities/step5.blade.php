<div class="app-card">
    <div class="navbar navbar-light app-new-activities-form-menu">
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link app-activity-invite-toggle" href="#">
                    @lang('app/activities_new.select_friends')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link app-activity-invite-toggle" href="#">
                    @lang('app/activities_new.invite')
                </a>
            </li>
        </ul>
    </div>

    <div class="app-relative app-block app-shadow-none app-border-none w-100 p-a-0 m-a-0 app-overflow-hidden app-activity-invite-block">
        <div class="row m-a-1">
            <div class="col-xs-12">
                <div class="app-inline-block">
                    <svg class="app-new-activities-form-search-icon">
                        <use xlink:href="#svg__search"></use>
                    </svg>
                </div>
                <div class="app-inline-block app-color-grey">
                    @lang('app/activities_new.search')
                </div>
            </div>
        </div>
        <div class="app-activity-scroll">
            <div class="row">
                @php($length = 10)
                <div class="col-xs-12 col-lg-6 p-x-0">
                    @for ($i = 0; $i < $length; $i++)
                        @php($id = mt_rand(1,500))
                        @if($i == 0 || $i%2 == 0)
                            <div class="dropdown-item app-dropdown-item-checkbox app-white-space-nowrap">
                                <label class="btn-block app-checkbox-label app-activity-p-l-3">
                                    <div class="app-checkbox"></div>
                                    <img src="{{ $faker->user() }}"
                                         class="m-l-1 app-activity-going-image" alt="User">
                                    <input class="hidden-xs-up" name="invited[{{ $id }}]"
                                           type="checkbox">
                                    <span>{{ $nameFaker->firstName }}  {{ $nameFaker->lastName }}</span>
                                </label>
                            </div>
                        @endif
                    @endfor
                    <div class="app-activity-h-4 w-100"></div>
                </div>
                <div class="col-xs-12 col-lg-6 p-x-0">
                    @for ($i = 0; $i < $length; $i++)
                        @php($id = mt_rand(1,500))
                        @if($i == 1 || $i%2 == 1)
                            <div class="dropdown-item app-dropdown-item-checkbox app-white-space-nowrap">
                                <label class="btn-block app-checkbox-label">
                                    <div class="app-checkbox"></div>
                                    <img src="{{ $faker->user() }}"
                                         class="m-l-1 app-activity-going-image" alt="User">
                                    <input class="hidden-xs-up" name="invited[{{ $id }}]"
                                           type="checkbox">
                                    <span>{{ $nameFaker->firstName }}  {{ $nameFaker->lastName }}</span>
                                </label>
                            </div>
                        @endif
                    @endfor
                    <div class="app-activity-h-4 w-100"></div>
                </div>
                <div class="app-activity-block-invite-shadow"></div>
            </div>
        </div>
    </div>
    <div class="app-p-card app-relative app-block app-shadow-none app-border-none w-100  m-t-0 app-overflow-hidden app-activity-invite-block hidden-xs-up">
        <div id="app_invite_inputs_block">
            <div class="form-group row">
                <div class="col-xs-3">
                    <button type="button" id="add_invite_input"
                            class="pull-xs-left btn btn-sm app-btn-apply app-activity-btn m-x-2">@lang('app/activities_new.add')</button>
                </div>
                <div class="col-xs-9">
                    <input class="form-control" name="invite[]" type="email">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @include('app.activities.buttons', ['link' => trans('app/activities_new.back'), 'btn' => trans('app/activities_new.finish'), 'url' => '#', 'step' => 5])
    </div>
</div>

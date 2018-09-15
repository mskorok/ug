
<section class="app-filters{{-- app-slide-down--}}" id="filters" hidden="hidden">
    <div class="app-section">
        <form id="activity_filters" method="GET">
            <h5 class="app-color-grey m-b-1">Search in activities</h5>
            <div class="row">

                {{-- search --}}
                <div class="col-lg-4 form-group app-relative">
                    <svg width="22" height="22" class="app-absolute-right-block m-r-2">
                        <use xlink:href="#svg__search_v2" fill="#BBB"></use>
                    </svg>

                    <input type="search" name="search" class="form-control" placeholder="Title, description...">

                </div>

                {{-- categories --}}
                <div class="col-lg-4">
                    <div class="form-group">

                        {{-- CustomSelect:categories --}}
                        <div data-form-input="categories" class="dropdown dropdown-block" >

                            {{-- label/placeholder --}}
                            <div role="button" class="app-btn-void dropdown-toggle w-100" id="filter_category_dropdown" data-toggle="dropdown">
                                Categories
                            </div>

                            {{-- options menu --}}
                            <div class="dropdown-menu w-100" aria-labelledby="filter_category_dropdown">
                                @foreach(trans('models/categories') as $category_id => $category_name)
                                <div role="button" class="dropdown-item" data-value="{{ $category_id }}"
                                @if (isset($_GET['categories']) && in_array($category_id, $_GET['categories']))
                                    data-selected
                                @endif
                                >
                                    {{ $category_name }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- interests --}}
                <div class="col-lg-4 form-group app-relative">
                    <svg width="22" height="22" class="app-absolute-right-block m-r-2">
                        <use xlink:href="#svg__tag" fill="#BBB"></use>
                    </svg>
                    <input type="search" name="interest" class="form-control" placeholder="Interests">
                </div>

            </div>
            <div class="row">

                {{-- location --}}
                <div class="col-lg-4 form-group app-relative">
                    <svg width="22" height="22" class="app-absolute-right-block m-r-2">
                        <use xlink:href="#svg__location" fill="#BBB"></use>
                    </svg>
                    <input type="search" name="location" class="form-control" placeholder="Location">
                </div>

                {{-- date --}}
                <div class="col-lg-4 form-group app-relative">
                    {{--<svg width="22" height="22" class="app-absolute-right-block m-r-2">
                        <use xlink:href="#svg__calendar" fill="#BBB"></use>
                    </svg>
                    <input type="text" name="date" class="form-control" placeholder="Date">--}}


                    {{-- CustomSelect:dateselect --}}
                    <div data-form-input="dateselect" class="dropdown dropdown-block" >

                        {{-- label/placeholder --}}
                        <svg width="22" height="22" class="app-absolute-right-block m-r-1">
                            <use xlink:href="#svg__calendar" fill="#BBB"></use>
                        </svg>
                        <div role="button" class="app-btn-void dropdown-toggle dropdown-no-triangle w-100" id="filter_dateselect_dropdown" data-toggle="dropdown">
                            Date
                        </div>

                        {{-- options menu --}}
                        <div class="dropdown-menu w-100" aria-labelledby="filter_dateselect_dropdown">
                            <a role="button" class="dropdown-item" data-value="1"
                               @if (isset($_GET['dateselect']) && $_GET['dateselect'] === 1)
                               data-selected
                                @endif
                            >
                                This week
                            </a>
                            <a role="button" class="dropdown-item" data-value="2"
                               @if (isset($_GET['dateselect']) && $_GET['dateselect'] === 2)
                               data-selected
                                    @endif
                            >
                                Next week
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <div class="text-xs-center">
                <input type="submit" value="Apply filters" class="btn app-btn-apply app-border-radius-4">
            </div>

        </form>
    </div>
</section>


<section class="app-section">

    <h2 class="app-title app-index-title">{{ trans('app/index.categories_title') }}</h2>
    <h4 class="app-subtitle app-index-subtitle">{{ trans('app/index.categories_desc') }}</h4>

    <div class="app-container-1300">

    <div class="row">

        <div class="col-lg-8">
            <a class="app-category" href="{{ url('/activities?categories[0]=1') }}">
                <div class="app-category-background app-category-1"></div>
                <div class="app-category-card">
                    <div class="app-category-icon app-category-1-icon"></div>
                    <h3 class="app-category-title">{{ trans('models/categories.1') }}</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a class="app-category" href="{{ url('/activities?categories[1]=1') }}">
                <div class="app-category-background app-category-2"></div>
                <div class="app-category-card">
                    <div class="app-category-icon app-category-2-icon"></div>
                    <h3 class="app-category-title">{{ trans('models/categories.2') }}</h3>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <a class="app-category" href="{{ url('/activities?categories[2]=1') }}">
                <div class="app-category-background app-category-3"></div>
                <div class="app-category-card">
                    <div class="app-category-icon app-category-3-icon"></div>
                    <h3 class="app-category-title">{{ trans('models/categories.3') }}</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a class="app-category" href="{{ url('/activities?categories[3]=1') }}">
                <div class="app-category-background app-category-4"></div>
                <div class="app-category-card">
                    <div class="app-category-icon app-category-4-icon"></div>
                    <h3 class="app-category-title">{{ trans('models/categories.4') }}</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a class="app-category" href="{{ url('/activities?categories[4]=1') }}">
                <div class="app-category-background app-category-5"></div>
                <div class="app-category-card">
                    <div class="app-category-icon app-category-5-icon"></div>
                    <h3 class="app-category-title">{{ trans('models/categories.5') }}</h3>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <a class="app-category" href="{{ url('/activities?categories[5]=1') }}">
                <div class="app-category-background app-category-6"></div>
                <div class="app-category-card">
                    <div class="app-category-icon app-category-6-icon"></div>
                    <h3 class="app-category-title">{{ trans('models/categories.6') }}</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a class="app-category" href="{{ url('/activities?categories[6]=1') }}">
                <div class="app-category-background app-category-7"></div>
                <div class="app-category-card">
                    <div class="app-category-icon app-category-7-icon"></div>
                    <h3 class="app-category-title">{{ trans('models/categories.7') }}</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a class="app-category" href="{{ url('/activities?categories[7]=1') }}">
                <div class="app-category-background app-category-8"></div>
                <div class="app-category-card">
                    <div class="app-category-icon app-category-8-icon"></div>
                    <h3 class="app-category-title">{{ trans('models/categories.8') }}</h3>
                </div>
            </a>
        </div>
    </div>

    </div>

</section>

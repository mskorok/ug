<section class="app-new-activities-form app-new-activities-decor clearfix">
    <div class="navbar navbar-light app-new-activities-form-menu">
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Select friends</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">invite via mail</a>
            </li>
        </ul>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-1">
            <svg class="app-new-activities-form-search-icon">
                <use xlink:href="#search"></use>
            </svg>
        </div>
        <div class="col-lg-4  app-new-activities-form-search-text">
            Search by keyword
        </div>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-6">
            <div>
                <img class="app-new-activities-photo" src="/img/app/navbar/profile.png"/>
                <div class="app-inline-block m-l-2 app-new-activities-form-text">Susan Cunningham</div>
            </div>
            <div>
                <img class="app-new-activities-photo" src="/img/app/navbar/profile.png"/>
                <div class="app-inline-block m-l-2 app-new-activities-form-text">Susan Cunningham</div>
            </div>
            <div>
                <img class="app-new-activities-photo" src="/img/app/navbar/profile.png"/>
                <div class="app-inline-block m-l-2 app-new-activities-form-text">Susan Cunningham</div>
            </div>
            <div>
                <img class="app-new-activities-photo" src="/img/app/navbar/profile.png"/>
                <div class="app-inline-block m-l-2 app-new-activities-form-text">Susan Cunningham</div>
            </div>

        </div>
        <div class="col-lg-6">
            <div>
                <img src="/img/app/categories/checked-1.png"/>
                <img class="app-new-activities-photo m-l-1" src="/img/app/navbar/profile.png"/>
                <div class="app-inline-block m-l-2 app-new-activities-form-text">Susan Cunningham</div>
            </div>
            <div>
                <img src="/img/app/categories/unchecked.png"/>
                <img class="app-new-activities-photo m-l-1" src="/img/app/navbar/profile.png"/>
                <div class="app-inline-block m-l-2 app-new-activities-form-text">Susan Cunningham</div>

            </div>
            <div>
                <img src="/img/app/categories/unchecked.png"/>
                <img class="app-new-activities-photo m-l-1" src="/img/app/navbar/profile.png"/>
                <div class="app-inline-block m-l-2 app-new-activities-form-text">Susan Cunningham</div>

            </div>
            <div>
                <img src="/img/app/categories/unchecked.png"/>
                <img class="app-new-activities-photo m-l-1" src="/img/app/navbar/profile.png"/>
                <div class="app-inline-block m-l-2 app-new-activities-form-text">Susan Cunningham</div>

            </div>
        </div>
    </div>
    @include('app.activities.buttons', ['link' => 'Back', 'btn' => 'Create', 'url' => '#'])
</section>

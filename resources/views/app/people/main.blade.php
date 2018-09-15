@extends('app.people._layouts.people')

<div class="navbar navbar-light app-navbar app-subnavbar">
    <ul id="nav_items" class="nav navbar-nav">
        <li id="nav_new" class="nav-item active">
            <a href="#" class="nav-link active">New</a>
        </li>
        <li id="nav_popular" class="nav-item">
            <a href="#" class="nav-link ">Popular</a>
        </li>
        <li id="nav_friends" class="nav-item">
            <a href="#" class="nav-link">Friends of friends</a>
        </li>
    </ul>

    @include('app._partials.categories', ['categories' => $categories])
</div>

<section id="people_new" class="app-people-section">
    @include('app.people.new')
</section>

<section id="people_popular" class="app-people-section hidden-xs-up">
    @include('app.people.popular')
</section>

<section id="people_friends" class="app-people-section hidden-xs-up">
    @include('app.people.friends')
</section>

@if ($showMore)
    <div class="row app-section">
        <div class="col-xs-12 col-md-6 col-xl-8 col-xxl-9 col-xxxl-10 p-b-2">
            <button id="btn_more" type="button" class="btn app-btn-apply app-text-sm app-border-radius-4 col-xs-12">Show more</button>
        </div>
    </div>
@endif
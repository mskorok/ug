@extends('app._layouts.app')
@section('content')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" property='stylesheet'>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <section class="app-new-activities clearfix hidden-md-down">
        <form  id="add_edit_activity_form" role="form" method="POST" action=""
               {{--action="{{ url('/admin/adventures/'. (($action == 'create') ? $action : 'edit'  ).'/' .($adventure->id ?? '')) }}"--}}
               enctype="multipart/form-data" novalidate="novalidate">
            {!! csrf_field() !!}
            <div class="col-lg-8 p-a-2 ">
                @include('app.activities._partials.top', ['step' => 1])
                <section class="app-new-activities-step1">
                    @include('app.activities.step1')
                </section>
                <section class="app-new-activities-step2 hidden-xs-up">
                    @include('app.activities.step2')
                </section>
                <section class="app-new-activities-step3 hidden-xs-up">
                    @include('app.activities.step3')
                </section>
                <section class="app-new-activities-step4 hidden-xs-up">
                    @include('app.activities.step4')
                </section>
                {{--<section class="app-new-activities-step5">--}}
                    {{--@include('app.activities._partials.step5')--}}
                {{--</section>--}}
            </div>
            <div class="col-lg-4 p-a-2 ">
                @include('app.activities._partials.help')
                @include('app.activities._partials.recent')
            </div>
        </form>
    </section>
    <section class="app-new-activities hidden-lg-up">
        <form  id="add_edit_adventure_form" role="form" method="POST"
               {{--action="{{ url('/admin/adventures/'. (($action == 'create') ? $action : 'edit'  ).'/' .($adventure->id ?? '')) }}"--}}
               enctype="multipart/form-data">
            <div class=" p-a-1">
                @include('app.activities._partials.top', ['step' => ($step ?? 1)])
                <section class="app-new-activities-step1">
                    @include('app.activities._partials.step1_mobile')
                </section>
                <section class="app-new-activities-step2 hidden-xs-up">
                    @include('app.activities._partials.step2_mobile')
                </section>
                <section class="app-new-activities-step3 hidden-xs-up">
                    @include('app.activities._partials.step3_mobile')
                </section>
                <section class="app-new-activities-step4 hidden-xs-up">
                    @include('app.activities._partials.step4_mobile')
                </section>
                {{--<section class="app-new-activities-step5">--}}
                    {{--@include('app.activities._partials.step5_mobile')--}}
                {{--</section>--}}
                @include('app.activities._partials.help')
                @include('app.activities._partials.recent')
            </div>
        </form>
    </section>
@endsection
{{--<script>--}}
    {{--document.addEventListener('DOMContentLoaded', function() {--}}
        {{--var next_steps = document.getElementsByClassName('app-new-activities-next');--}}
        {{--var back_steps = document.getElementsByClassName('app-new-activities-back');--}}
        {{--console.log(next_steps);--}}
        {{--console.log(back_steps);--}}
{{--//    next_steps.forEach(function(el) {--}}
{{--//        el.addEventListener('click', function (e) {--}}
{{--//            e.stopPropagation();--}}
{{--//            e.preventDefault();--}}
{{--//            var step = this.getAttribute('data-step');--}}
{{--//        });--}}
{{--//    });--}}

        {{--[].forEach.call(next_steps, function (el) {--}}
            {{--el.addEventListener('click', function (e) {--}}
                {{--e.stopPropagation();--}}
                {{--e.preventDefault();--}}
                {{--var step = parseInt(this.getAttribute('data-step'));--}}
                {{--switch (step) {--}}
                    {{--case 1:--}}
                        {{--toStep(2);--}}
                        {{--break;--}}
                    {{--case 2:--}}
                        {{--toStep(3);--}}
                        {{--break;--}}
                    {{--case 3:--}}
                        {{--toStep(4);--}}
                        {{--break;--}}
                    {{--case 4:--}}
                        {{--createActivity();--}}
                        {{--break;--}}
                    {{--default:--}}
                        {{--break;--}}
                {{--}--}}
                {{--return false;--}}
            {{--});--}}
        {{--});--}}

        {{--[].forEach.call(back_steps, function (el) {--}}
            {{--el.addEventListener('click', function (e) {--}}
                {{--e.stopPropagation();--}}
                {{--e.preventDefault();--}}
                {{--var step = parseInt(this.getAttribute('data-step'));--}}
                {{--switch (step) {--}}
                    {{--case 1:--}}
                        {{--cancelCreation();--}}
                        {{--break;--}}
                    {{--case 2:--}}
                        {{--toStep(1);--}}
                        {{--break;--}}
                    {{--case 3:--}}
                        {{--toStep(2);--}}
                        {{--break;--}}
                    {{--case 4:--}}
                        {{--toStep(3);--}}
                        {{--break;--}}
                    {{--default:--}}
                        {{--break;--}}
                {{--}--}}
                {{--return false;--}}
            {{--});--}}
        {{--});--}}
    {{--});--}}



    {{--function cancelCreation() {--}}
        {{--return true;--}}
    {{--}--}}

    {{--function toStep(step) {--}}
        {{--var sections = document.querySelectorAll('[class^=app-new-activities-step]');--}}
        {{--[].forEach.call(sections, function (el) {--}}
            {{--el.classList.add('hidden-xs-up');--}}
        {{--});--}}
        {{--var steps = document.getElementsByClassName('app-new-activities-top-step');--}}
        {{--[].forEach.call(steps, function (el) {--}}
            {{--el.innerHTML = step + ' of 4';--}}
        {{--});--}}
        {{--var class_name = 'app-new-activities-step' + step;--}}
        {{--var back_steps = document.getElementsByClassName(class_name);--}}
        {{--[].forEach.call(back_steps, function (el) {--}}
            {{--el.classList.remove('hidden-xs-up');--}}
        {{--});--}}
        {{--return false;--}}
    {{--}--}}
    {{--function createActivity() {--}}
        {{--document.forms['add_edit_activity_form'].submit();--}}
    {{--}--}}




{{--</script>--}}


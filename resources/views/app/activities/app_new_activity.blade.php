@extends('app._layouts.app')

@section('javascript')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script type="text/javascript" src="/vendors/daterangepicker_edited.js"></script>
    <script src="//cdn.ckeditor.com/4.5.8/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
@endsection

@section('content')
    {{--<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500"
          property='stylesheet'>--}}
    <section class="app-new-activities">
        <div class="row">
            <div class="col-xs-12 col-lg-8 p-a-2 ">
                <form id="add_edit_activities_form"  method="POST"  enctype="multipart/form-data" novalidate>
                    {!! csrf_field() !!}

                    {{-- Step Header --}}
                    <div class="app-relative app-card app-card-b-shadow">
                        <div class="app-p-card">
                            <div class="row">
                                <div class="col-xs-7 col-lg-6">
                                    <h1 class="app-new-activities-top-title">
                                        @lang('app/activities_new.new_activity')
                                    </h1>
                                    <div class="app-t-subtitle">
                                        @lang('app/activities_new.info')
                                    </div>
                                </div>
                                <div class="col-xs-5 col-lg-6 ">
                                    <h1 class="app-new-activities-top-step  text-xs-right">
                                        <span id="app_new_activities_top_step">1</span> @lang('app/activities_new.of') 5
                                    </h1>
                                    <div class="app-t-subtitle text-xs-right">
                                        @lang('app/activities_new.steps')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="app_new_activities_step1">
                        @include('app.activities.step1')
                    </div>

                    <div id="app_new_activities_step2" class="hidden-xs-up">
                        @include('app.activities.step2')
                    </div>

                    <div id="app_new_activities_step3" class="hidden-xs-up">
                        @include('app.activities.step3')
                    </div>

                    <div id="app_new_activities_step4" class="hidden-xs-up">
                        @include('app.activities.step4')
                    </div>

                    <div id="app_new_activities_step5" class="hidden-xs-up">
                        @include('app.activities.step5')
                    </div>

                </form>
            </div>

            <div class="col-xs-12 col-lg-4 p-a-2 ">
                <div class="app-card app-p-card m-b-2">
                    {{--<div class="row">
                        <div class="col-xs-12 text-xs-center">
                            @lang('app/activities_new.first_activity')
                        </div>
                        <div class="col-xs-12 app-color-grey-dark">
                            @lang('app/activities_new.first_activity_help_text')
                        </div>
                        <div class="col-xs-12 text-xs-right">
                            @lang('app/activities_new.hide_help')
                        </div>
                    </div>--}}
                    <p>@lang('app/activities_new.help', ['link' => '<a href="#">'.trans('app/activities_new.help_link').'</a>'])</p>
                    <div style="text-align: right">
                        <button type="button" id="activity_hide_help" class="btn app-btn-apply btn-sm">@lang('app/activities_new.help_hide')</button>
                    </div>
                </div>
                {{--<div class="p-a-1 app-card app-p-card">
                    <div class="row">
                        <div class="col-xs-12 text-xs-center">145 activities found in Germany</div>
                        <div class="col-xs-12 w-100 app-color-grey-dark" style="height: 10rem;"></div>
                    </div>
                </div>--}}
            </div>
        </div>
    </section>
@endsection

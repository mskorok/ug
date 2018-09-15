@extends('app._layouts.app')
@section('app_scripts')
    @parent
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script type="text/javascript" src="/vendors/daterangepicker_edited.js"></script>
    <script src="//cdn.ckeditor.com/4.5.8/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
        Lib.setRequired('description');
    </script>
@endsection
@section('content')
    <section class="app-new-reviews">
        <div class="row">
            <div class="col-xs-12 col-lg-8 p-a-2 ">
                <form id="add_edit_reviews_form"  method="POST"  enctype="multipart/form-data" novalidate>
                    {!! csrf_field() !!}
                    <div class="app-card app-new-reviews-top app-p-card">
                        <div class="row">
                            <div class="col-xs-7 col-lg-6">
                                <h1 class="app-new-reviews-top-title">
                                    @lang('app/reviews_new.new_review')
                                </h1>
                                <div class="app-t-subtitle">
                                    @lang('app/reviews_new.info')
                                </div>
                            </div>
                            <div class="col-xs-5 col-lg-6 ">
                                <h1 class="app-new-reviews-top-step  text-xs-right">
                                    <span id="app_new_reviews_top_step">1</span> of 3
                                </h1>
                                <div class="app-t-subtitle text-xs-right">
                                    @lang('app/reviews_new.steps')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="app_new_reviews_step1">
                        @include('app.reviews.step1')
                    </div>
                    <div id="app_new_reviews_step2" class="hidden-xs-up">
                        @include('app.reviews.step2')
                    </div>
                    <div id="app_new_reviews_step3" class="hidden-xs-up">
                        @include('app.reviews.step3')
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-lg-4 p-a-2 ">
                <div class="app-card app-p-card m-b-2">
                    <div class="row">
                        <div class="col-xs-12 text-xs-center">
                            @lang('app/reviews_new.first_review')
                        </div>
                        <div class="col-xs-12 app-color-grey-dark">
                            @lang('app/reviews_new.first_review_help_text')

                        </div>
                        <div class="col-xs-12 text-xs-right">
                            @lang('app/reviews_new.hide_help')
                        </div>
                    </div>
                </div>
                <div class="p-a-1 app-card app-p-card">
                    <div class="row">
                        <div class="col-xs-12 text-xs-center">145 reviews found in Germany</div>
                        <div class="col-xs-12 w-100 app-color-grey-dark" style="height: 10rem;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

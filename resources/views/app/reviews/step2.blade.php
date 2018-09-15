<div class="app-new-reviews-form app-card app-p-card">
    <div class="form-group row">
        <label class="col-xs-12  col-lg-3  p-l-1 col-form-label" for="gallery">
            @lang('app/reviews_new.gallery')</label>
        <div class="col-xs-12 col-lg-9">
            <div class="app-inline-block app-opacity-0">
                <input type="file" accept="image/*" id="gallery" multiple="multiple" class="app-new-reviews-hidden-upload" name="files[]">
            </div>
            <div class="app-new-reviews-hide-input">
                <button  type="button" id="select_gallery" class="btn  btn-sm app-btn-outline-apply">
                    <span>
                        @lang('app/reviews_new.gallery_upload')
                    </span>
                </button>
            </div>


            {{--<div id="gallery_delete_checkbox" class="checkbox m-a-1">--}}
            {{--<label>--}}
            {{--<input type="checkbox" id="delete_gallery_preview" name="delete_gallery_preview" value="1">--}}
            {{--<span>Delete image</span>--}}
            {{--</label>--}}
            {{--</div>--}}
        </div>
    </div>
    <div class="col-xs-12 col-lg-3"></div>
    <div class="col-xs-12 col-lg-9">
        <div class="m-b-1">
            <div  id="gallery_preview"></div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-xs-12 col-lg-4 col-xl-3 p-l-1 col-form-label app-line-height" for="description">
            @lang('app/reviews_new.story')
        </label>
        <div class="col-xs-12 col-lg-7 col-xl-8  p-r-1 app-center-block app-text-editor-child-width">
            <textarea id="description" required="required" class="form-control app-new-reviews-form-input" rows="6"
                  name="description" ></textarea>
            <div class="help-block app-color-grey-dark app-text-sm">
                @lang('app/reviews_new.story_help_text')
            </div>
        </div>
    </div>
    <div class="row">
        @include('app.reviews.buttons', ['link' => trans('app/reviews_new.back'), 'btn' => trans('app/reviews_new.next'), 'url' => '#', 'step' => 2])
    </div>
</div>
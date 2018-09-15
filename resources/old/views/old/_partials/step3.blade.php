<section class="app-new-activities-form  app-new-activities-decor clearfix">

    <fieldset class="form-group row">
        <label class="col-lg-4 col-xl-3 form-control-label app-line-height" for="category_sys_id">Choose Category of
            activity </label>
        <div class="col-lg-7 col-xl-8">
            <div class="form-group form-group-select-arrow">
                <select id="category_sys_id" name="category_sys_id" class="form-control" size="1">
                    @foreach($categories as $key => $category)
                        <option value="{{ $key }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <label class="col-lg-4 col-xl-3 form-control-label app-line-height" for="description">
            This activity is all about
        </label>
        <div class="col-lg-7 col-xl-8">
            <div id="interests_hidden_block"></div>
            <div class=" p-y-1 m-b-1" id="interests_for_creation"></div>

            <div class="form-group">
                <div class="app-relative">
                    <input id="new_activity_interest_autocomplete" class="form-control  awesomplete" type="text" name="autocomplete"
                           placeholder="Type your interest keyword">
                    <input id="add_interest_to_new_activity" type="button" value="Add" class="app-btn-in-input">
                </div>
                <div class="app-new-activities-form-text m-t-1">For better results you should add at least 5 keywords
                </div>
            </div>
        </div>
    </fieldset>
    @include('app.activities.buttons', ['link' => 'Back', 'btn' => 'Next step', 'url' => '#', 'step' => 3])
</section>

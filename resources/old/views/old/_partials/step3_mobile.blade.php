<section class="app-new-activities-form  app-new-activities-decor clearfix">
    <div class="col-xs-12">

        <label class="form-control-label app-line-height" for="category_sys_id">Choose Category of activity </label>
        <div class="form-group  form-group-select-arrow">
            <select id="category_sys_id"  name="category_sys_id" class="form-control" size="1">
                @foreach($categories as $key => $category)
                    <option value="{{ $key }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-12">
        <div id="interests_hidden_block_mobile"></div>
        <div id="interests_for_creation_mobile"></div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            <label class="form-control-label app-line-height" for="new_activity_interest_autocomplete_mobile">Tell a bit more about your plan or
                idea</label>
            <div class="form-group">
                <div class="app-relative">
                    <input id="new_activity_interest_autocomplete_mobile" class="form-control  awesomplete" type="text" name="autocomplete"
                           placeholder="Type your interest keyword">
                    <input id="add_interest_to_new_activity_mobile" type="button" value="Add" class="app-btn-in-input">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 app-new-activities-form-text">For better results you should add at least 5 keywords</div>
    @include('app.activities.buttons', ['link' => 'Back', 'btn' => 'Next step', 'url' => '#', 'step' => 3])
</section>
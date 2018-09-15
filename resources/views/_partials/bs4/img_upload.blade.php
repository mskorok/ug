{{--
Partial for bootstrap4 form input type="file" for image upload

@param $input - input/column name and id

@param $value - optional, input value
@param $label - optional, default to input name
@param $autofocus - optional
--}}
<fieldset class="form-group {{ $errors->has($input) ? ' has-danger' : '' }}">
    <div class="col-lg-6">
        <label class="col-form-label" for="{{ $input }}">{{ $label ?? $input }}</label>
        <input type="file" accept="image/*" id="{{ $input }}" class="form-control {{ $errors->has($input) ? ' form-control-danger' : '' }}" name="{{ $input }}" value="{{ old($input) ?? $value ?? '' }}" @if(isset($autofocus)) autofocus @endif>
        <div id="{{ $input }}_delete_checkbox" class="checkbox m-a-1">
            <label>
                <input type="checkbox" id="{{ $input }}_delete" name="{{ $input }}_delete" value="1">
                <span>Delete image</span>
            </label>
        </div>
    </div>
    <div class="col-lg-6">
        <img id="{{ $input }}_image" class="admin-img-upload-preview" src="{{ $value ?? '' }}" alt="{{ $label ?? $input }} preview">
    </div>
    @if ($errors->has($input))
        <small class="text-help">{{ $errors->first($input) }}</small>
    @endif
</fieldset>

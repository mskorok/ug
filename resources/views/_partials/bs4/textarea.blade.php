{{--
Partial for bootstrap4 form textarea (label, input and error message)

@param $input - input/column name and id

@param $value - optional, input value
@param $label - optional, default to input name
@param $autofocus - optional
@param $maxlength - optional
--}}
<fieldset class="form-group {{ $errors->has($input) ? ' has-danger' : '' }}">
    <label class="col-form-label" for="{{ $input }}">{{ $label ?? $input }}</label>
    <textarea id="{{ $input }}" class="form-control {{ $errors->has($input) ? ' form-control-danger' : '' }}" rows="{{ $rows ?? 3 }}" name="{{ $input }}" @if(isset($maxlength)) maxlength="{{ $maxlength }}" @endif @if(isset($autofocus)) autofocus @endif>
        {{ old($input) ?? $value ?? '' }}
    </textarea>
    @if ($errors->has($input))
        <small class="text-help">{{ $errors->first($input) }}</small>
    @endif
</fieldset>

{{--
Partial for bootstrap4 form input (label, input and error message)

@param $input - input/column name and id

@param $value - optional, input value
@param $label - optional, default to input name
@param $type  - optional, input type, default text
@param $autofocus - optional
@param $required - optional
@param $maxlength - optional
--}}


<fieldset class="form-group {{ $errors->has($input) ? ' has-danger' : '' }}">
    <label class="col-form-label @if(isset($required)) required @endif"
           for="{{ $input }}">{{ $label ?? $input }}</label>
    <input type="{{ $type ?? 'text' }}" id="{{ $input }}" @if(isset($maxlength)) maxlength="{{ $maxlength }}" @endif
    class="form-control {{ $errors->has($input) ? ' form-control-danger' : '' }}" name="{{ $input }}"
           value="{{ old($input) ?? $value ?? '' }}" @if(isset($autofocus)) autofocus
           @endif @if(isset($required)) required @endif>
    @if ($errors->has($input))
        <small class="text-help">{{ $errors->first($input) }}</small>
    @endif
</fieldset>



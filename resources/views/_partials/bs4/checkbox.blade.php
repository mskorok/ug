{{--
Partial for bootstrap4 form checkbox input

@param $input - input name and id

@param $value - optional, input value
@param $label - optional, default to input name
@param $type  - optional, input type, default text
--}}

<fieldset class="m-t-1 checkbox form-group {{ $errors->has($input) ? ' has-danger' : '' }}">
    <label class="col-form-label" for="{{ $input }}">
        <input @if (! empty($checked)) checked @endif type="checkbox" id="{{ $input }}" name="{{$input}}" value="{{$value ?? ''}}" class="m-r-1" type="checkbox" value="{{$value ?? ''}}">{{ $label ?? $input }}
    </label>
    @if ($errors->has($input))
        <small class="text-help">{{ $errors->first($input) }}</small>
    @endif
</fieldset>
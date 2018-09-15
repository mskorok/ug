{{--
Select for bootstrap 4 using custom styles
http://v4-alpha.getbootstrap.com/components/forms

@param $input - input/column name and id
@param $data - array of key => value pairs

@param $label - optional, default to input name
@param $selected - optional, key
--}}
<fieldset class="form-group {{ $errors->has($input) ? ' has-danger' : '' }}">
    <label class="col-form-label" for="{{ $input }}">{{ $label ?? $input }}</label>

    <select class="form-control {{ $errors->has($input) ? ' form-control-danger' : '' }}" name="{{ $input }}"  id="{{ $input }}">
        @foreach ($data as $key => $option)
            <option value="{{ $key }}"
                @if (old($input))
                    @if ($key === old($input))
                        selected="selected"
                    @endif
                @elseif($selected ?? null)
                    @if ($key === $selected)
                        selected="selected"
                    @endif
                @endif
            >{{ $option }}</option>
        @endforeach
    </select>
    @if ($errors->has($input))
        <small class="text-help">{{ $errors->first($input) }}</small>
    @endif
</fieldset>

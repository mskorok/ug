{{--
Partial for bootstrap4 form input (label, input and error message)

@param $input - input/column name and id

@param $value - optional, input value
@param $label - optional, default to input name
@param $type  - optional, input type, default text
@param $autofocus - optional
@param $required - optional

$data = [
    [
        'value' => 1,
        'label' => 'First option',
        'checked' => true

    ],
    [
        'value' => 2,
        'label' => 'Second option',
        'checked' => false

    ]

]
--}}
<fieldset class="form-group {{ $errors->has($input) ? ' has-danger' : '' }}">
    <div>{{ $label ?? $input }}</div>
    @foreach($data as $item)
        <div class="checkbox">
            <label  class="col-form-label" for="{{ $input }}_{{ $item['label'] }}">
                <input type="checkbox"  id="{{ $input }}_{{ $item['label'] }}"  class="form-control {{ $errors->has($input) ? ' form-control-danger' : '' }}" {{ (($item['checked']) ? 'checked' : ''); }}   name="{{ $input }}[]" value="{{ $item['value'] }}" @if(isset($autofocus)) autofocus @endif @if(isset($required)) required="required" @endif   @if($item['checked'])   checked = "checked" @endif >
                {{ $item['label] }}
            </label>
        </div>
    @endforeach
    @if ($errors->has($input))
        <small class="text-help">{{ $errors->first($input) }}</small>
    @endif
</fieldset>
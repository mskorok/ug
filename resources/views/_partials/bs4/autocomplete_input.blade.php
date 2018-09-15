<fieldset class="form-group {{ $errors->has($input) ? ' has-danger' : '' }}">
    <label class="col-form-label @if(isset($required)) required @endif"
           for="{{ $input }}">{{ $label ?? $input }}</label>
    <div id="{{ $input }}_autocomplete" class="dropdown">
        <input type="text" id="{{ $input }}"
           class="form-control {{ $errors->has($input) ? ' form-control-danger' : '' }}" name="{{ $input }}"
           value="{{ old($input) ?? $value ?? '' }}" @if(isset($autofocus)) autofocus
           @endif @if(isset($required)) required @endif>
        @if(isset($hidden_input)) <input type="hidden" name="{{ $hidden_input }}" id="{{ $hidden_input }}"> @endif
    </div>
    @if ($errors->has($input))
        <small class="text-help">{{ $errors->first($input) }}</small>
    @endif
</fieldset>

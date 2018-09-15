{{--
Partial for multiselection list

@param $input - input name and id
@param $label - optional, no label if empty
@param $data - array of data items:
    [
        ...
        [
            'name' => <string>, // Is shown in UI
            'selected' => <boolean>
        ]
        ...
    ]

--}}

@if (isset($label))
    <label class="col-form-label" for="{{ $input }}">{{ $label }}</label>
@endif

<ul id="{{ $input }}">
    @foreach ($data as $itemId => $itemData)
        <li class="list-item {{ (is_array($itemData) && array_key_exists('selected', $itemData) && $itemData['selected'])  ? 'selected' : '' }} {{ $class ?? '' }}" data-id={{ $itemId }}>
            @if(is_string($itemData))
                {{ $itemData }}
            @elseif(is_array($itemData) && array_key_exists('name', $itemData) /* && !empty($params['name'])*/)
                {{ $itemData['name'] }}
            @else
                <?php throw new \Exception('Error in _partials/multi_select_list'); ?>
            @endif
        </li>

        @if (isset($itemData['selected']) && $itemData['selected'] !== false)
            <input type="hidden" id="id_{{$itemId}}" value="{{$itemId}}" name="{{$input}}[]">
        @endif
    @endforeach
</ul>
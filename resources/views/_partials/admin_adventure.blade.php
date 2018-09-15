<tr>
    <td v="id">
        {{ $adventure->id }}
    </td>
    <td>
        <img av="src:promo_image" src="{{ $adventure->promo_image }}" alt="Profile photo" class="col-md-12">
    </td>
    <td v="place_name">
        {{ $adventure->place_name }}
    </td>
    <td v="title">
        <a href="{{ url('/admin/adventures/show/'.$adventure->id) }}">{{ $adventure->title  }}</a>
    </td>
    <td v="short_description">
        {{ $adventure->short_description  }}
    </td>
    <td v="created_at">
        {{ $adventure->created_at }}
    </td>
    <td class="adventure-list-buttons">
        <a href="{{ route('adventure_edit', ['adventure' => $adventure->id]) }}" class="btn btn-sm btn-primary" av="href:edit_link">Edit</a>
        &nbsp;&nbsp;
        <a href="{{ route('adventure_delete', ['adventure' => $adventure->id]) }}" class="btn btn-sm btn-danger" av="href:delete_link">Delete</a>
    </td>
</tr>

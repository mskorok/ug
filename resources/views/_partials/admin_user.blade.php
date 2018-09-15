<tr>
    <td v="id">
        {{ $user->id }}
    </td>
    <td>
        <img av="src:photo_path" src="{{ $user->photo_path }}" alt="Profile photo" class="img-circle admin-img-profile">
    </td>
    <td v="name">
        {{ $user->getName() }}
    </td>
    <td v="email">
        {{ $user->email }}
    </td>
    <td v="created_at">
        {{ $user->created_at }}
    </td>
    <td>
        -
    </td>
    <td>
        <a href="{{ url('/admin/users/' . $user->id) }}" class="btn btn-sm btn-primary" av="href:link">Edit</a>
        <a href="{{ url('/admin/users/' . $user->id . '/delete') }}" class="btn btn-sm btn-danger" av="href:delete_link">Delete</a>
    </td>
</tr>

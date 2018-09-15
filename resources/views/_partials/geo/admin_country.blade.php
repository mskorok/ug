<tr>
    <td>
        {{ $country->id }}
    </td>
    <td>
        {{ $country->iso_alpha2 }}
    </td>
    <td>
        {{ $country->name }}
    </td>
    <td>
        <a class="fa fa-pencil-square-o admin-tb-default" href="{{ url('admin/countries/'.$country->id) }}"></a>
        <a class="fa fa-times admin-tb-red" href="{{ url('admin/countries/'.$country->id.'/delete') }}" onclick=""></a>
    </td>
</tr>

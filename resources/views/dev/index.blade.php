@extends('_layouts.dev')

@section('header')
    .env
@endsection

@section('content')


    <div class="card">
        <div class="card-header h3">.env file, DB connection and app key</div>
        <div class="card-block">


    @if (!file_exists('../.env'))
        <a class="btn btn-primary" href="/dev/dotenv">Create .env file</a>
    @else
        <form method="POST" action="/dev/dotenv">
        <table class="table table-striped table-hover">
            <tr class="thead-inverse">
                <th>env</th>
                <th>value</th>
            </tr>
            <?php $prev_key_cat = ''; ?>
            @foreach($_ENV as $k => $v)
                @if ($prev_key_cat !== '' && $prev_key_cat !== explode('_', $k)[0])
                    @if ($prev_key_cat === 'DB')
                        <tr>
                            @if ($con_msg)
                            <td colspan="2" style="color: red">
                                {{ $con_msg }}
                            </td>
                            @else
                            <td colspan="2" style="color: green">
                                Connection successful
                            </td>
                            @endif
                        </tr>
                    @endif
                    <tr class="thead-inverse">
                        <th></th>
                        <th></th>
                    </tr>
                @endif
                <?php $prev_key_cat = explode('_', $k)[0]; ?>
                @if ($k === 'APP_KEY' && strlen($v) !== 32)
                <tr class="table-danger">
                    <td>
                        {{$k}}
                        <a class="btn btn-primary" href="/dev/appkey">Generate app key</a>
                    </td>
                @else
                <tr>
                    <td>{{$k}}</td>
                @endif

                    <td><input type="text" name="{{$k}}" value="{{$v}}" class="form-control"></td>
                </tr>
            @endforeach
        </table>
            <input class="btn btn-primary" type="submit" name="submit" value="Update .env file">
            <a class="btn btn-primary" href="/dev/appkey">Generate app key</a>
        </form>
    @endif

        </div>
    </div>

    <div class="card m-t-3">
        <div class="card-header h3">CLI</div>
        <div class="card-block">
            <a class="btn btn-primary" href="/dev/composer-install">composer install</a><br>
            <br>
            <a class="btn btn-primary" href="/dev/db-rebuild">db hard delete, migrate and seed</a><br>
        </div>
    </div>

@endsection

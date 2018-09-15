@foreach($friends as $user)
    @include('app._partials.person', ['user' => $user])
@endforeach

@foreach($adventures as $adventure)
    <div class="col-lg-6 col-xl-4 col-xxxl-3">
        @include('app._partials.adventure_block', ['adventure' => $adventure])
    </div>
@endforeach

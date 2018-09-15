@foreach($reviews as $review)
    @include('app._partials.review_block', ['review' => $review])
@endforeach

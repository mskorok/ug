@extends('_layouts.admin')

@section('header')
    Admin dashboard
@endsection

@section('content')
    <h4 style="font-style: italic; color: #888">„{{ $quote }}“</h4>
    - {{ $author }}
@endsection

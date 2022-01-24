@extends('layout')

@section('main')

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            @foreach ($products as $product)
                {{ $product->name }}
            @endforeach
        </div>
    </div>
</div>

@endsection

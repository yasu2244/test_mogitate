@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    <div class="product-show-container">
        <h1>{{ $product->name }}</h1>
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
        <p>値段: ¥{{ $product->price }}</p>
        <p>季節: 
            @foreach($product->seasons as $season)
                {{ $season->name }}
            @endforeach
        </p>
        <p>{{ $product->description }}</p>
        <a href="{{ route('products') }}" class="btn btn-secondary">戻る</a>
    </div>
@endsection

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="message-space">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>商品一覧</h2>
            <a href="{{ route('products.create') }}" class="btn btn-primary custom-btn">+ 商品を追加</a>
        </div>
        <div class="row">
            <div class="col-md-3">
                <form action="{{ route('products.search') }}" method="GET">
                    <div class="form-group search-form-group">
                        <input type="text" name="query" class="form-control search-input" placeholder="商品名で検索" value="{{ request('query') }}">
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">検索</button>
                    <div class="form-group mt-4 sort-form-group">
                        <label for="sort">価格順で表示</label>
                        <select name="sort" id="sort" class="form-control sort-select">
                            <option value="" disabled selected hidden>価格で並び替え</option>
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>低い順に表示</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="col-md-9">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">¥{{ $product->price }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('js/custom-search.js') }}"></script>

@endsection

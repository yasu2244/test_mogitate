@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
    <div class="product-create-container">
        <h1>商品登録</h1>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 商品名 -->
            <div class="form-group">
                <label for="name" class="form-label">
                    商品名 
                    <span class="required-field">必須</span>
                </label>
                <input type="text" name="name" class="form-control" id="name" placeholder="商品名を入力" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- 値段 -->
            <div class="form-group">
                <label for="price" class="form-label">
                    値段 
                    <span class="required-field">必須</span>
                </label>
                <input type="number" name="price" class="form-control" id="price" placeholder="値段を入力" value="{{ old('price') }}" required>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- 画像の選択 -->
            <div class="form-group">
                <label for="image" class="form-label">
                    商品画像 
                    <span class="required-field">必須</span>
                </label>
                <div class="register__file">
                    <label class="file__label">ファイルを選択
                        <input class="file__input" type="file" id="image" name="image" required>
                    </label>
                    <div class="file__name" id="fileName"></div>
                </div>
                <img id="previewImage" src="#" alt="選択された画像" class="image-preview">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- 季節 -->
            <div class="form-group">
                <label for="season" class="form-label">
                    季節 
                    <span class="required-field">必須</span>
                <span class="optional-label">複数選択可</span></label>
                <div class="season-select-container">
                    <div class="register__radio">
                        <label class="radio__label">
                            <input name="seasons[]" type="checkbox" class="radio__input" value="1" {{ is_array(old("seasons")) && in_array("1", old("seasons"), true) ? ' checked' : '' }}>
                            春
                        </label>
                        <label class="radio__label">
                            <input name="seasons[]" type="checkbox" class="radio__input" value="2" {{ is_array(old("seasons")) && in_array("2", old("seasons"), true) ? ' checked' : '' }}>
                            夏
                        </label>
                        <label class="radio__label">
                            <input name="seasons[]" type="checkbox" class="radio__input" value="3" {{ is_array(old("seasons")) && in_array("3", old("seasons"), true) ? ' checked' : '' }}>
                            秋
                        </label>
                        <label class="radio__label">
                            <input name="seasons[]" type="checkbox" class="radio__input" value="4" {{ is_array(old("seasons")) && in_array("4", old("seasons"), true) ? ' checked' : '' }}>
                            冬
                        </label>
                    </div>
                    @error('seasons')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- 商品説明 -->
            <div class="form-group">
                <label for="description" class="form-label">
                    商品説明 
                    <span class="required-field">必須</span>
                </label>
                <textarea name="description" class="form-control" id="description" placeholder="商品の説明を入力" value="{{ old('description') }}" required></textarea>
            </div>

            <!-- 戻る・登録ボタン -->
            <div class="form-buttons">
                <a href="{{ route('products') }}" class="btn btn-secondary">戻る</a>
                <button type="submit" class="btn btn-primary">登録</button>
            </div>
        </form>
    </div>

<script src="{{ asset('js/file-preview.js') }}"></script>   
@endsection
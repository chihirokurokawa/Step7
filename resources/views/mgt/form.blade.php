@extends('layout')
@section('title', '商品新規登録画面')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>商品新規登録フォーム</h2>
        <form method="POST" action="{{ route('store') }}" onSubmit="return checkSubmit()">
            @csrf
            
            <div class="form-group">
                <label for="product_name">
                    商品名
                </label>
                <input
                    id="product_name"
                    name="product_name"
                    class="form-control"
                    value="{{ old('product_name') }}"
                    type="text"
                >
                @if ($errors->has('product_name'))
                    <div class="text-danger">
                        {{ $errors->first('product_name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="company_name">
                    メーカー
                </label>
                <input
                    id="company_name"
                    name="company_name"
                    class="form-control"
                    value="{{ old('company_name') }}"
                    type="text"
                >
                @if ($errors->has('company_name'))
                    <div class="text-danger">
                        {{ $errors->first('company_name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="price">
                    価格
                </label>
                <input
                    id="price"
                    name="price"
                    class="form-control"
                    value="{{ old('price') }}"
                    type="text"
                >
                @if ($errors->has('price'))
                    <div class="text-danger">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="stock">
                    在庫数
                </label>
                <input
                    id="stock"
                    name="stock"
                    class="form-control"
                    value="{{ old('stock') }}"
                    type="text"
                >
                @if ($errors->has('stock'))
                    <div class="text-danger">
                        {{ $errors->first('stock') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="comment">
                    コメント
                </label>
                <textarea
                    id="comment"
                    name="comment"
                    class="form-control"
                    rows="4"
                >{{ old('comment') }}</textarea>
                @if ($errors->has('comment'))
                    <div class="text-danger">
                        {{ $errors->first('comment') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="img_path">
                    商品画像
                </label>
                <input
                    id="img_path"
                    name="img_path"
                    class="form-control"
                    value="{{ old('img_path') }}"
                    type="text"
                >
                @if ($errors->has('img_path'))
                    <div class="text-danger">
                        {{ $errors->first('img_path') }}
                    </div>
                @endif
            </div>
            <div class="mt-5">
                <a class="btn btn-secondary" href="{{ route('mgts') }}">
                    キャンセル
                </a>
                <button type="submit" class="btn btn-primary">
                    登録
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function checkSubmit(){
if(window.confirm('送信してよろしいですか？')){
    return true;
} else {
    return false;
}
}
</script>
@endsection
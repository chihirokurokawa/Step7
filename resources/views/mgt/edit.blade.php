@extends('layout')
@section('title', '商品編集')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-4">
        <h2>商品編集フォーム</h2>
        <form method="POST" action="{{ route('update') }}" enctype="multipart/form-data" onSubmit="return checkSubmit()">
            @csrf
            
            <input type="hidden" name="id" value="{{ $product->id }}">
            <div class="form-group">
            <label for="product_name">
            商品名
            </label>
                <input
                    id="product_name"
                    name="product_name"
                    class="form-control"
                    value="{{ $product->product_name }}"
                    type="text"
                >
                @if ($errors->has('product_name'))
                    <div class="text-danger">
                        {{ $errors->first('product_name') }}
                    </div>
                @endif
            </div>
            
            <div class="form-group">
            <label for="company_id">
                メーカー名
            </label>
        
            


            <select class="form-control{{ $errors->has('company_id') ? ' is-invalid' : '' }}" name="company_id" id="company_id">
        <option></option>
        @foreach ($products as $product)
            @if (!is_null(old('company_id')))
                <!-- バリデーションエラー等による再表示時 -->
                @if ($product->company_id == old('company_id'))
                    <option value="{{ $product->company_id }}" selected>{{ $product->company_name }}</option>
                @else
                    <option value="{{ $product->company_id }}">{{ $product->company_name }}</option>
                @endif
            @else
                <!-- 初期表示時 -->
                @if ($product->company_id == $company->id)
                    <option value="{{ $product->company_id }}" selected>{{ $product->company_name }}</option>
                @else
                    <option value="{{ $product->company_id }}">{{ $product->company_name }}</option>
                @endif
            @endif
        @endforeach
    </select>

  

                @if ($errors->has('company_id'))
                    <div class="text-danger">
                        {{ $errors->first('company_id') }}
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
                    value="{{ $product->price }}"
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
                    value="{{ $product->stock }}"
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
                >{{ $product->comment }}</textarea>
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
                type="file"
                class="form-control-file"
                name="img_path"
                value="{{ $product->img_path }}"
                >
                設定中：<img src="{{ asset ('/storage/images/' . $product->img_path ) }}">
                
                
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
                更新
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function checkSubmit(){
if(window.confirm('更新してよろしいですか？')){
    return true;
} else {
    return false;
}
}
</script>
@endsection
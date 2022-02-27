@extends('layout')
@section('title', '商品情報詳細画面')
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    
      <span>商品情報ID：{{ $product->company_id }}</span>
      <p>商品画像：{{ $product->img_path }}</p>
      <h2>商品名：{{ $product->product_name }}</h2>
      <span>メーカー：{{ $product->company_name }}</span>
      <span> 価格：{{ $product->price }}</span>
      <span>在庫数：{{ $product->stock }}</span>
      <p>コメント：{{ $product->comment }}</p>
        

      <a href="/product/{{ $product->id }}">{{ $product->product_name }}>
      編集
      </a>
      <a class="btn btn-secondary" href="{{ route('mgts') }}">
      戻る
      </a>
    
  </div>
</div>
@endsection

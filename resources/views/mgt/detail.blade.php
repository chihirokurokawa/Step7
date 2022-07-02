@extends('layout')
@section('title', '商品情報詳細画面')
@section('content')
<div class="row">

  <div class="col-md-8 col-md-offset-2">

      <p>商品情報ID：{{ $product->id }}</p>
      <p>商品画像：{{ $product->img_path }}</p>
      <h2>商品名：{{ $product->product_name }}</h2>
      <p>メーカー：{{ $product->company->company_name }}</p>
      <p> 価格：{{ $product->price }}</p>
      <p>在庫数：{{ $product->stock }}</p>
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

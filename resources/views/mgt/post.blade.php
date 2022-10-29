@extends('layout')
@section('title', '商品情報一覧画面')
@section('content')
<div class="row">
  <div class="col-md-11 col-md-offset-1">

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<title>検索</title>

<body>
<h2>商品検索</h2>
    <form  method="GET" action="/post"> //postへ商品の名前を飛ばしてます 
      <input type="text" name="product_name">
      <input type="submit" value="検索">
    </form>
</body>
</html>
一覧を表示させるページ

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>書籍検索</title>

<body>
<h2>蔵書検索結果</h2>
<p>検索キーワード：{{$title}}</p> 

@if(!$items->isEmpty()) //検索結果があるか確認してある時の処理（@emptyじゃオブジェクトなので無理です）
<table>
    <tr><th>本の名前</th><th>著者名</th><th>出版日</th></tr>
    @foreach($items as $item) //$itemsでコントローラーから渡された値を＠foreachで表示します。
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->author}}</td>
            <td>{{$item->day}}</td>
        </tr>  
    @endforeach
{{ $items->appends(Request::only('title'))->links()}} //ここが肝です。下記で説明します。
</table>
@else　//検索結果があるか確認して無い時の処理
   <p>該当する書籍は存在しません</p>
   <h2>蔵書検索</h2>
   <form  method="GET" action="/booklist">
       <input type="text" name="title">
       <input type="submit" value="検索">
   </form>
@endif





  <form method="GET" action="{{ route('mgt.post') }}">
    <h2>検索</h2>
    <div>
      <label for="category-id">{{ __('商品名') }}</label>
      <input  type="search" 
              placeholder="商品名を入力" 
              name="search" 
              value="@if (isset($search)) {{ $search }} @endif">
      <label for="category-id">{{ __('メーカー名') }}</label>
        <select class="form-control"  name="search" >
          @foreach($products as $product)
          <option>{{ $product->company_name }}</option>
          @endforeach]
        </select>
    </div>
             

      <div>
        <button type="submit">検索</button>
        <button>
            <a href="{{ route('mgt') }}" class="text-white">
                クリア
            </a>
        </button>
      </div>
</form>
<!-- 
@foreach($products as $product)
    <a href="{{ route('mgts', ['product_name' => $product->product_name]) }}">
        {{ $product->product_name }}
    </a>
@endforeach -->



      <h2>商品情報一覧</h2>
        @if (session('err_msg'))
            <p class="text-danger">
                {{ session('err_msg') }}
            </p>
        @endif
      <table class="table table-striped">
          <tr>
              <th>ID</th>
              <th>商品画像</th>
              <th>商品名</th>
              <th>価格</th>
              <th>在庫数</th>
              <th>メーカー名</th>
              <th>詳細</th>
              <th>削除</th>

          </tr>
          @foreach($products as $product)
          <tr>
              <td>{{ $product->id }}</td>
              <td><img src='/storage/images/{{ $product->img_path }}' class='img-fluid'/></td>
              <td>{{ $product->product_name }}</td>
              <td>{{ $product->price }}</td>
              <td>{{ $product->stock }}</td>
              <td>{{ $product->company_name }}</td>

              <td>
                <button 
                type="button" 
                class="btnbtn-primary" 
                onclick="location.href='/product/{{ $product->id }}'">
                詳細
                </button>
              </td>

            <form 
              method="POST" 
              action="{{ route('delate', $product->id) }}" 
              onSubmit="return checkDelete()">
              @csrf
            　  <td>
                  <button type="submit" 
                  class="btnbtn-primary" 
                  onclick=>
                  削除
                  </button>
                </td>
            </form>
          </tr>
          @endforeach
      </table>
  </div>
</div>
<script>
function checkDelete(){
if(window.confirm('削除してよろしいですか？')){
    return true;
} else {
    return false;
}
}
</script>
@endsection

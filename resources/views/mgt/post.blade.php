@extends('layout')
@section('title', '商品情報一覧画面')
@section('content')
<div class="row">
  <div class="col-md-11 col-md-offset-1">

  <title>検索と一覧</title>
    
     <h2>商品検索</h2>
    <div class="search">
    <form action="{{ route('post') }}" method="GET">
            @csrf

    <div class="form-group">
        <div>
            <label for="">商品名
              <div>       
                <input type="text" name="product_keyword">
               
              </div>
            </label>
        </div>
        <div>
            <label for="">会社名
              <div>
                <select name="company_keyword" data-toggle="select">
                    <option value="">全て</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company -> id }}">{{ $company -> company_name }}</option>
                    @endforeach
                </select>
              </div>
            </label>
        </div>
        <div>
            <input type="submit" class="btn" value="検索">
        </div>
      </div>
    </form>
  </div>


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

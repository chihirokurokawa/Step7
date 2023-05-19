@extends('layout')
@section('title', '商品情報一覧画面')
@section('content')

<div class="row">
  <div class="col-md-11 col-md-offset-1">
    
    <h2>商品検索</h2>
    <div class="search">
      <form action="{{ route('search') }}" method="POST" id="search-form">
        @csrf
        <div class="form-group">
          <div>
            <label for="">商品名
              <div>
                <input type="text" id="product_keyword" name="product_keyword">
              </div>
            </label>
          </div>
          <div>
            <label for="">会社名
              <div>
                <select id="company_keyword" name="company_keyword" data-toggle="select">
                  <option value="">全て</option>
                  @foreach ($companies as $company)
                  <option value="{{ $company -> id }}">{{ $company -> company_name }}</option>
                  @endforeach
                </select>
              </div>
            </label>
          </div>

          <div>
            <label for="">価格
              <div>
                <input type="number" id="price_min" name="price_min" placeholder="下限">
                〜
                <input type="number" id="price_max" name="price_max" placeholder="上限">
              </div>
            </label>
          </div>

          <div>
            <label for="">在庫数
              <div>
                <input type="number" id="stock_min" name="stock_min" placeholder="下限">
                〜
                <input type="number" id="stock_max" name="stock_max" placeholder="上限">
              </div>
            </label>
          </div>

          <div>
            <button type="submit" class="btn btn-primary" id="search-button">検索</button>
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

      <!-- <table class="table table-striped" id="product-table"> -->
      <table class="table table-striped" id="search-result-table">
      
          <tr>
              <th scope="col">@sortablelink('id', 'ID')</th>
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
              <td scope="row" >{{ $product->id }}</td>
              <td><img src='/storage/images/{{ $product->img_path }}' class='img-fluid'/></td>
              <td>{{ $product->product_name }}</td>
              <td>{{ $product->price }}</td>
              <td>{{ $product->stock }}</td>
              <td>{{ $product->company_name }}</td>
              <td>
                <button 
                type="button" 
                class="btn btn-primary" 
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
                  class="btn btn-primary" 
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // $('#search-button').click(function(event){
    //     event.preventDefault(); // デフォルトのsubmitアクションを防止する
    //     $('#search-form').submit(); // フォームのsubmitイベントをトリガーする
    // });
    
    // $('#search-button').click(function(event){
    $('#search-button').on('submit', function(event){
        event.preventDefault(); // デフォルトのsubmitアクションを防止する
        var product_keyword = $('#product_keyword').val();
        var company_keyword = $('#company_keyword').val();
        var price_min = $('#price_min').val();
        var price_max = $('#price_max').val();
        var stock_min = $('#stock_min').val();
        var stock_max = $('#stock_max').val();
        
        $.ajax({
          type: 'POST',
          url: '{{ route("search") }}',
          data: {
            product_keyword: product_keyword,
            company_keyword: company_keyword,
            price_min: price_min,
            price_max: price_max,
            stock_min: stock_min,
            stock_max: stock_max,
            _token: '{{ csrf_token() }}'
          },
          success: function(data){
            // $('#search-result-table tbody').html(data);
            $('#search-result-table').html(data);

          }
        });
        $(this)[0].reset();
    });
});

</script>

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
@extends('layout')
@section('title', '商品情報一覧画面')
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
      <h2>商品情報一覧</h2>
      <table class="table table-striped">
          <tr>
              <th>ID</th>
              <th>日付</th>
              <th>タイトル</th>
              <th></th>
          </tr>
          <tr>
              <td>1</td>
              <td>2020/06/30</td>
              <td>テスト</td>
              <td></td>
          </tr>
      </table>
  </div>
</div>
@endsection

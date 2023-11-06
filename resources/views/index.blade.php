@extends('layouts.app')
  
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-left">
                <h2 style="font-size:1rem;">自動販売機</h2>
            </div>
            <div class="text-right">
            <a class="btn btn-success" href="{{ route('product.create') }}">新規登録</a>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td style="text-align:right">{{ $product->id }}</td>
            <td>商品画像</td>
            <td style="text-align:right">{{ $product->product_name }}</td>
            <td style="text-align:right">{{ $product->price }}円</td>
            <td style="text-align:right">{{ $product->stock }}</td>
            <td style="text-align:right">{{ $product->company_id }}</td>
            <a class=”btn btn-primary” href="{{ route('product.edit',$product->id) }}">詳細</a> 
        </tr>
        @endforeach
    </table>
 
@endsection
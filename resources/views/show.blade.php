@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 style="font-size:1rem;">商品情報詳細画面</h2>
            </div>
        </div>
    </div>
    
    <div style="text-align:left;">
        <form  action="{{ route('product.edit',$product->id) }}"  method="POST" enctype="multipart/form-data">
         @method('PUT')
         @csrf
        <table class="table table-bordered">

        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <tr>
                <th>ID</th>
                <td style="text-align:right">{{ $product->id }}</td>
            </tr>
            </div>
        </div>

        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <tr>
                <th>商品画像</th>
                <td><img style="width:80px;" src="{{asset('storage/images'.$product->img_path)}}" ></td>
            </tr>
            </div>
        </div>

        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <tr>
                <th>商品名</th>
                <td style="text-align:right">{{ $product->product_name }}</td>
            </tr>
            </div>
        </div>

            <tr>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <th>メーカー</th>
                <td style="text-align:right">
                    @foreach ($companies as $companie)
                        @if ($companie->id==$product->company_id) {{ $companie->company_name }} @endif
                    @endforeach
                </td>
            </tr>
            </div>
        </div>

        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <tr>
                <th>価格</th>
                <td style="text-align:right">{{ $product->price }}円</td>
            </tr>
            <tr>
            </div>
        </div>

        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <th>在庫数</th>
                <td style="text-align:right">{{ $product->stock }}</td>
            </tr>
            </div>
        </div>

        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <tr>
                <th>コメント</th>
                <td style="text-align:right">{{ $product->comment }}</td>
            </tr>
            </div>
        </div>
        </table>
        <div class="col-12 mb-2 mt-2">
             <a class="btn btn-success" href="{{ route('product.edit',$product->id) }}">編集</a>
        </div>

        <div class="col-12 mb-2 mt-2">
            <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
        </div>
    </div>
</form>
@endsection




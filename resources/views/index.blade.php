@extends('layouts.app')
  
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-left">
                <h2 style="font-size:1rem;">自動販売機</h2>
            </div>
            <div>
                <form action="{{ route('product.index') }}" method="GET">
                @csrf
                    <input type="text" name="keyword">
                    <select name="companies_name" data-toggle="select">
                        <option value="">メーカー名</option>
                            @foreach ($companies as $companie)
                        <option value="{{ $companie->id }}">{{ $companie->company_name }}</option>
                            @endforeach
                    </select>

                        <input type="submit" class="btn" value="検索">
                </form>
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
            <th>詳細表示</th>
            <th>削除</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td style="text-align:right">{{ $product->id }}</td>
            <td><img style="width:80px;" src="{{asset('storage/images'.$product->img_path)}}" ></td>
            <td style="text-align:right">{{ $product->product_name }}</td>
            <td style="text-align:right">{{ $product->price }}円</td>
            <td style="text-align:right">{{ $product->stock }}</td>
            <td style="text-align:right">{{ $product->company_name }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('product.show',$product->id) }}">詳細</a> 
            </td>
            <td style=”text-align:center”>
                <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか？");'>削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $products->links('vendor.pagination.bootstrap-4') }}
 
@endsection
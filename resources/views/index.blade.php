@extends('layouts.app')
  
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-left">
                <h2 style="font-size:1rem;">自動販売機</h2>
            </div>
                <form action="" method="GET">
                @csrf
                    <input type="text" name="keyword">
                    <select name="companies_name" data-toggle="select">
                        <option value="">メーカー名</option>
                            @foreach ($companies as $companie)
                        <option value="{{ $companie->id }}">{{ $companie->company_name }}</option>
                            @endforeach
                    </select>
                    
                    <div class="price.search">
                        <div class="jougen">
                            <label for="jougen">価格上限</label>
                            <input type="number" name="jougenpr" min="100" max="500">
                        </div>

                        <div class="kagen">
                            <label for="kagen">価格下限</label>
                            <input type="number" name="kagenpr" min="100" max="500">
                        </div>
                    </div>

                    <div class="stock.search">
                        <div class="jougen">
                            <label for="jougen">在庫上限</label>
                            <input type="number" name="jougenst" min="1" max="500">
                        </div>

                        <div class="kagen">
                            <label for="kagen">在庫下限</label>
                             <input type="number" name="kagenst" min="1" max="500">
                        </div>
                    </div>

                    <button id="btn" class="btn btn-secondary" >検索</button>

                </form>

                    <div class="text-right">
                        <a class="btn btn-success" href="{{ route('product.create') }}">新規登録</a>
                    </div>
        
                    <table id="productTable" class="table table-bordered">
                        <tr>
                            <th data-column="id">@sortablelink('id','ID')</th>
                            <th>商品画像</th>
                            <th data-column="product_name">@sortablelink('product_name','商品名')</th>
                            <th data-column="price">@sortablelink('price','価格')</th>
                            <th data-column="stock">@sortablelink('stock','在庫数')</th>
                            <th data-column="company_name">@sortablelink('company_name','メーカー')</th>
                            <th>詳細表示</th>
                            <th>削除</th>
                        </tr>      
                    </table>
        </div>     
    </div>             

                <form action="" method="GET">
                @csrf
                    <script src="{{ asset('js/ajax.js') }}"></script>
    {{ $products->links('vendor.pagination.bootstrap-4') }}
 
@endsection
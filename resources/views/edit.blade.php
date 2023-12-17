@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 style="font-size:1rem;">商品情報編集画面</h2>
            </div>
        </div>
    </div>
    
    <div style="text-align:left;">
        <form  action="{{ route('product.update',$product->id) }}"  method="POST" enctype="multipart/form-data">
         @method('PUT')
         @csrf
            <div class="form-group">
                <p>ID:{{ $product->id }}</p>                
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="name" value="{{ $product->product_name }}" class="form-control" placeholder="商品名">
                @error('name')
                    <span style="color:red;">名前を20文字以内で入力してください</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <select name="companies_id" class="form-select">
                    <option>メーカー名を選択してください</option>
                    @foreach ($companies as $companie)
                        <option value="{{ $companie->id }}"@if ($companie->id==$product->company_id) selected @endif>{{ $companie->company_name }}</option>
                    @endforeach
                </select>
                @error('companies_id')
                    <span style="color:red;">メーカー名を選択してください</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="price" value="{{ $product->price }}" class="form-control" placeholder="価格">
                @error('price')
                    <span style="color:red;">価格を数値で入力してください</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="stock" value="{{ $product->stock }}" class="form-control" placeholder="在庫数">
                @error('stock')
                    <span style="color:red;">在庫数を入力してください</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <textarea class="form-control" style="height:100px" name="comment" placeholder="コメント">{{ $product->comment }}</textarea>
            @error('comment')
                    <span style="color:red;">コメントを入力してください</span>
            @enderror
            </div>
        </div>
        <div class="image-table">
            <tr>
                <input type="file" name="image">
            </tr>
        </div>
        <div class="col-12 mb-2 mt-2">
                <button type="submit" class="btn btn-success">変更</button>
        </div>
        
        
        <div class="col-12 mb-2 mt-2">
            <a class="btn btn-success" href="{{ route('product.show',$product->id) }}">戻る</a>
        </div>
    </div>
</form>
@endsection

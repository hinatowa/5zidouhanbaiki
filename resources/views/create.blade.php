@extends('layouts.app')

@section('content')

<div class="row">
    @if(session('message'))
    <div class = "text-red-600 font-bold">
        {{ session('messege') }}
    </div>
    @endif
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="商品名">
                @error('name')
                    <span style=”color:red;”>名前を20文字以内で入力してください</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <select name="sale" class="form-select">
                    <option>分類を選択してください</otion>
                    @foreach ($sales as $sale)
                        <option value="{{ $sale->id }}">{{ $sale->product_id }}</otion>
                    @endforeach
                </select>
                @error('company_id')
                    <span style=”color:red;”>分類を選択してください</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="price" class="form-control" placeholder="価格">
                @error('price')
                    <span style=”color:red;”>価格を数値で入力してください</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="stock" class="form-control" placeholder="在庫数">
                @error('stock')
                    <span style=”color:red;”>在庫数を入力してください</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <textarea class="form-control" style="height:100px" name="shosai" placeholder="コメント"></textarea>
            @error('comment')
                    <span style=”color:red;”>詳細を入力してください</span>
            @enderror
            </div>
        </div>
        <!-- <div class="image-table">
            <tr>
                <td><img name="ju_image" class="ju_image" src="#" alt="image">商品画像</td>
                <td><input id="image" type="file" name="image"></td>
            </tr>
        </div> -->
        <div class="col-12 mb-2 mt-2">
        <a class="btn btn-success" href="{{ url('/list') }}">新規登録</a>
        </div>
        
        <form method = "post" action = "{{ route('store') }}">  
         @csrf  
         <div class="col-12 mb-2 mt-2">
            <a class="btn btn-success" href="{{ url('/list') }}">戻る</a>
        </div>
    </div>
</form>
@endsection

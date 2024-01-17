@extends('layouts.app')
  
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-left">
                <h2 style="font-size:1rem;">自動販売機</h2>
            </div>
            <div>
                <form action="" method="GET">
                @csrf
                
                    <input type="text" name="keyword">
                    <select name="companies_name" data-toggle="select">
                        <option value="">メーカー名</option>
                            @foreach ($companies as $companie)
                        <option value="{{ $companie->id }}">{{ $companie->company_name }}</option>
                            @endforeach
                    </select>
                    
                   
                        <button class="btn" >検索</button>

                    <script>
                        
                        $('.btn').on('click', function (){
                            
                            const keyword = $('input[name="keyword"]').val();
                            const companies_name = $('select[name="companies_name"]').val();
                            $.ajax({
                                type: "get", //HTTP通信の種類
                                url: "/5zidouhanbaiki/public/product/getlistAjax",
                                dataType: "json",
                                data: { keyword : keyword , companies_name},
                                })
                                //通信が成功したとき
                                .done((res) => { // resの部分にコントローラーから返ってきた値 $users が入る
                                    $('#productTable').empty();
                                    console.log("Ajax成功");
                                    console.log(companies_name);
                                    console.log(keyword);
                                    console.log(res);
                                    $.each(res, function (index, value) {
                                        html = `
                                                    <tr class="product-list">
                                                        <td class="col-xs-2">${value.id}</td>
                                                        <td class="col-xs-2"><img style="width:80px;" src="http://localhost:8888/5zidouhanbaiki/public/storage/images/${value.img_path}"></td>
                                                        <td class="col-xs-2">${value.product_name}</td>
                                                        <td class="col-xs-2">${value.price }</td>
                                                        <td class="col-xs-2">${value.stock}</td>
                                                        <td class="col-xs-2">${value.company_name}</td>
                                                        <td class="col-xs-2"><a class="btn btn-primary" href="http://localhost:8888/5zidouhanbaiki/public/product/show/${value.id}">詳細</a></td>
                                                        <td class="col-xs-2"><button type="button" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか？");'>削除</button></td>
                                                    </tr>
                                        `;
                                         $("#productTable").append(html); //できあがったテンプレートを user-tableクラスの中に追加
                                    });
                                })
                                //通信が失敗したとき
                                .fail((error) => {
                                console.log("Ajax失敗");
                                console.log(error.statusText);
                                console.log(error);
                                });
                                
                            return false;
                            
                        });
                    </script>
                </form>
            </div>
            <div class="text-right">
            <a class="btn btn-success" href="{{ route('product.create') }}">新規登録</a>
            </div>
        </div>
    </div>
    <table id="productTable" class="table table-bordered">
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
        
    </table>
    {{ $products->links('vendor.pagination.bootstrap-4') }}
 
@endsection
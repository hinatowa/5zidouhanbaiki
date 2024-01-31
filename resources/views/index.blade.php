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
                        
                        <!-- @foreach ($products as $product)
                        <tr>
                            <td style="text-align:right">{{ $product->id }}</td>
                            <td><img style="width:80px;" src="{{asset('storage/images/'.$product->img_path)}}" ></td>
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
                                    <button type="submit" class="btn btn-danger" onclick='return confirm("削除しますか？");'>削除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach -->
                    </table>
        </div>     
    </div>             

                <form action="" method="GET">
                @csrf
                    <script>
                        $('#productTable th').on('click', function (){
                            const columnname=$(this).data("column");
                            console.log("クリックされた カラム名"+columnname);
                            let direction = $(this).hasClass("asc");
                            if(direction){
                                direction = "desc";
                            } else {
                                direction = "asc";
                            }
                            $(this).removeClass("asc desc");
                            $(this).addClass(direction);
                            ajaxRequest(columnname,direction);
                            return false;
                        });


                        $('#btn').on('click', function (){
                            ajaxRequest();
                            return false;
                        });

                        function ajaxRequest(columnname,direction){
                            $('.product-list').empty(); //値、画面を更新する。
                            const keyword = $('input[name="keyword"]').val();
                            const companies_name = $('select[name="companies_name"]').val();
                            const jougenpr = $('input[name="jougenpr"]').val();
                            const kagenpr = $('input[name="kagenpr"]').val();
                            const jougenst = $('input[name="jougenst"]').val();
                            const kagenst = $('input[name="kagenst"]').val();
                            $.ajax({
                                type: "get", //HTTP通信の種類
                                url: "/5zidouhanbaiki/public/product/getlistAjax",
                                dataType: "json",
                                data: {
                                        keyword : keyword ,
                                        companies_name ,
                                        jougenpr , 
                                        kagenpr , 
                                        jougenst , 
                                        kagenst ,
                                        sort: columnname,
                                        direction: direction,
                                    },
                            })
                                //通信が成功したとき
                                .done((res) => { // resの部分にコントローラーから返ってきた値 $products が入る                                    
                                    console.log("Ajax成功");
                                    // console.log(companies_name);
                                    // console.log(keyword);
                                    // console.log(jougenpr);
                                    // console.log(kagenpr);
                                    // console.log(jougenst);
                                    // console.log(kagenst);
                                    // console.log(res);                                   
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
                                                <td class="col-xs-2"><button data-product_id="${value.id}" type="button" class="btn btn-danger">削除</button></td>
                                            </tr>                                        
                                                `;
                                        $("#productTable").append(html); //できあがったテンプレートを table table-borderedクラスの中に追加
                                    });
                                })
                                //通信が失敗したとき
                                .fail((error) => {
                                console.log("Ajax失敗");
                                // console.log(error.statusText);
                                // console.log(error);
                                });
                            return false;
                        };
                    
                
                
                    
                        $.ajaxSetup({
                            headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    });

                            $(document).on('click', '.btn-danger', function(){
                                let deleteConfirm = confirm('削除してよろしいでしょうか？');                                
                                if(deleteConfirm == true) {
                                    let clickEle = $(this)
                                    let productID = clickEle.attr('data-product_id');
                                    console.log(productID);
                                    $.ajax({
                                        type: 'POST',
                                        url: '/5zidouhanbaiki/public/product/destroyAjax/' + productID,
                                        // url: '/product/destroyAjax/{id}'+productID, //productID にはレコードのIDが代入されています
                                        dataType: "json",
                                        data: {
                                            id : productID,
                                        },
                                    })
                                    
                                    .done(function(res)  { // resの部分にコントローラーから返ってきた値 $users が入る                                    
                                    console.log("Ajax成功");
                                    clickEle.parents('tr').remove();
                                    })
                                    .fail((error) => {
                                    console.log("Ajax失敗");
                                    });
                                    //”削除しても良いですか”のメッセージで”いいえ”を選択すると次に進み処理がキャンセルされます
                                } else {
                                    (function(e) {
                                    e.preventDefault()
                                    });
                                };
                                
                            });
                    </script>
    {{ $products->links('vendor.pagination.bootstrap-4') }}
 
@endsection
window.onload = function(){
    ajaxRequest();
    return false;
    };

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
    // headers: {
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             }
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                
    
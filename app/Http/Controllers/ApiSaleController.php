<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Companie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Product Created successfully!",
            'product' => $product
        ],);

    }

    public function index(Request $request)
    {
        $productID = $request->product_id;
        $products = Product::find($productID);
        //在庫数チェック③
        if(empty($products)){
            return response()->json("1商品が見つかりませんid=$productID");
        }

        if($products->stock <= 0){
            return response()->json("2在庫がありませんid=$productID");
        }

        try {
            DB::beginTransaction();
            //salesテーブルにレコードを追加①
            DB::table('sales')->insert([ 
                'product_id' => $productID
            ]);
            //productsテーブルも在庫数を減算②
            $stocksave = --$products->stock;
            //productテーブルのidが$productIDのstockを$stocksaveに更新する
            DB::table('products')->where('id', $productID)->update([
                'stock' => $stocksave
            ]);

            

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json("システムエラーです".$e);
        }
        return response()->json(Sale::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}

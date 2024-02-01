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
        $products = Product::query();
        $sales = sale::all();

        $products->join('sales','products.id','=','sales.product_id');	//内部結合

        

        return DB::table('sales')
            ->selectRaw('id')
            ->selectRaw('product_id')
            ->selectRaw('created_at')
            ->selectRaw('updated_at')
            ->get();
    //    return [
    //     "テスト" => true
    //    ];

    //    try {
    //     DB::beginTransaction();

    //     $sale = new Sales();
    //     return response()->json(Sales::all());


    //     DB::commit();
    //         } catch (Throwable $e) {
    //     DB::rollBack();
    //     }
    //    $sales = Sale::all();
    //         return response()->json([
    //             'status' => true,
    //             'sales' => $sales
    //     ]);
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

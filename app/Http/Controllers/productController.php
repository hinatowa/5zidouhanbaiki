<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Companie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /* テーブルから全てのレコードを取得する */
        $products = Product::query();//SELECT * FROM 'products'
        $companies = companie::all();
        $products->select('products.*','companies.company_name');
        $products->join('companies','products.company_id','=','companies.id');	//内部結合

        /* キーワードから検索処理 */
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {//$keyword　が空ではない場合、検索処理を実行します
            $products->where('product_name', 'LIKE', "%{$keyword}%");//SELECT * FROM products WHERE product_name LIKE '%コーラ%'
            }

        $companiey_id = $request->input('companies_name');
        if(!empty($companiey_id)) {//$companiey_name　が空ではない場合、検索処理を実行します
            $products->where('company_id', '=', "{$companiey_id}");//SELECT * FROM products WHERE company_id = 1
            }
            
            Product::with('companie')->get();

        $products = $products->paginate(5);
        return view('index',compact('products'))
        ->with('companies',$companies);
       
       
    }

    public function getlistAjax(Request $request)
    {
        $products = new Product();
        $products = $products->getList($request);
        
        return response()->json($products);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = companie::all();
        return view('create')
        ->with('companies',$companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $request->validate([
        'name' =>'required|max:20',
        'companies_id' => 'required|integer',
        'price' => 'required|integer',
        'stock' => 'required|integer',
        'comment' => 'required|max:140',
        'image' => 'image|max:1024'
        ]);

        try {
            DB::beginTransaction();

        $product = new Product();
        
        
        $product->company_id = $request->companies_id;
        $product->product_name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        
        if($request->image){
            $original = request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images',$name);
            $product->img_path = $name;
        }
        
        

        $product->save();

        DB::commit();
            } catch (Throwable $e) {
        DB::rollBack();
        }

        return redirect()->route('product.index')
        ->with('message','商品を登録しました');

            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $companies = Companie::all();
        return view('show',compact('product'))
        ->with('companies',$companies);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $companies = Companie::all();
        return view('edit',compact('product'))
        ->with('companies',$companies);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product)
    {
        try {
            DB::beginTransaction();
             $request->validate([
            'name' =>'required|max:20',
            'companies_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'required|max:140',
            'image' => 'image|max:1024'
            ]);

            $product->company_id = $request->companies_id;
            $product->product_name = $request->name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if($request->image){
                $original = request()->file('image')->getClientOriginalName();
                $name = date('Ymd_His').'_'.$original;
                request()->file('image')->move('storage/images',$name);
                $product->img_path = $name;
            }

            $product->save();

            DB::commit();
             } catch (Throwable $e) {
            DB::rollBack();
            }

            return redirect()->route('product.index');

            
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')
        ->with('success'.$product->name.'を削除しました');
    }

    public function destroyAjax(Request $request) 
    {
        //ajaxメソッドから送信されたデータは$requestに格納されます
        //ajas側で送信したデータの名前は"id"という名前に設定しているため
        //コントローラーで使うには $request->id で出力します
        $products = Product::find($request->id);
        //データベースのProductsテーブルから()で指定されたiDのレコードを代入します

        $products->delete();
        Log::debug("destroyAjaxproducts=".$products);
        //productsに代入されているレコード（行）を削除します
        // return redirect('/5zidouhanbaiki/public/product/getlistAjax');
        
        $products = $products->get();
        Log::debug("destroyAjax終了");
        return $products;   
    }
        
        
        
}

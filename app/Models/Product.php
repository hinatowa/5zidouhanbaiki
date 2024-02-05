<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;
    use Sortable;
   
    // protected $table = 'companies';
    public function Companie(){
        return $this -> belongsTo(Companie::class);
    }
    
    public function getList($request){
        $products = self::query();
        $products->select('products.*','companies.company_name');
        $products->join('companies','products.company_id','=','companies.id');	//内部結合
        
        
        /* キーワードから検索処理 */
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {//$keyword　が空ではない場合、検索処理を実行します
            $products->where('product_name', 'LIKE', "%{$keyword}%");//SELECT * FROM products WHERE product_name LIKE '%コーラ%'
            }

        /* セレクトから検索処理 */
        $companiey_id = $request->input('companies_name');
        if(!empty($companiey_id)) {//$companiey_name　が空ではない場合、検索処理を実行します
            $products->where('company_id', '=', "{$companiey_id}");//SELECT * FROM products WHERE company_id = 1
            }

        /* 価格上限から検索処理 */
        $jougenpr = $request->input('jougenpr');
        if(!empty($jougenpr)) {//$jougenpr　が空ではない場合、検索処理を実行します
            $products->where('products.price', '<=', "{$jougenpr}");//SELECT * FROM products WHERE product_price >= '$jougenpr'
            }

       /* 価格下限から検索処理 */
        $kagenpr = $request->input('kagenpr');
        if(!empty($kagenpr)) {//$kagenpr　が空ではない場合、検索処理を実行します
            $products->where('products.price', '>=', "{$kagenpr}");//SELECT * FROM products WHERE product_price >= '$kagenpr'
            }

       /* 在庫上限から検索処理 */
        $jougenst = $request->input('jougenst');
        if(!empty($jougenst)) {//$jougenst　が空ではない場合、検索処理を実行します
            $products->where('products.stock', '<=', "{$jougenst}");//SELECT * FROM products WHERE product_stock >= '$jougenst'
            }

       /* 在庫下限から検索処理 */
        $kagenst = $request->input('kagenst');
        if(!empty($kagenst)) {//$kagenst　が空ではない場合、検索処理を実行します
            $products->where('products.stock', '>=', "{$kagenst}");//SELECT * FROM products WHERE product_stock >= '$kagenst'
            }

        $sort = $request->input('sort');
        $direction = $request->input('direction');
        if(!empty($sort)) {//$kagenst　が空ではない場合、検索処理を実行します
            $products->orderBy($sort, $direction);//SELECT * FROM products WHERE product_stock >= '$kagenst'
            }

        $products = $products->get();
            
        return $products;
    }


    public $sortable = ['id','companu_id','product_name','price','stock'];//追記(ソートに使うカラムを指定

}


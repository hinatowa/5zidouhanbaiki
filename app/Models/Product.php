<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory;
    use Sortable;
    // protected $table = 'companies';
    public function Companie(){
        return $this -> belongsTo(Companie::class);
    }
    
    public $sortable = ['id','companu_id','product_name','price','stock'];//追記(ソートに使うカラムを指定
}

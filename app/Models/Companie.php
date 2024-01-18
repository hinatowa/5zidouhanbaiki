<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Companie extends Model
{
    use HasFactory;
    use Sortable;

    public function Products(){
        return $this -> hasMany(Product::class);
    }
}
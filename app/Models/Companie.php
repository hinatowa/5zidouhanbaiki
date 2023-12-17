<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Companie extends Model
{
    use HasFactory;

    public function Products(){
        return $this -> hasMany(Product::class);
    }
}
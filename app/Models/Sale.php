<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['product_id']; 

    //在庫を減らす処理
    public function decStock($id){
        DB::table('products')
            ->where('id','=',$id)
            ->decrement('stock');
        
        //在庫を減らした後の情報を返却
        $afterBuy = DB::table('products')
            ->select('id','product_name','stock')
            ->where('id','=',$id)
            ->first();
        
        return $afterBuy;
    }
    
    //salesテーブルインサート処理
    public function registSale($id){
        DB::table('sales')
            ->insert([
                'product_id' => $id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }
}

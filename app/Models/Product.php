<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'maker_name',
        'price',
        'stock',
        'comment',
        'img_path',
        'created_at',
        'updated_at',
        ];
    

    //商品新規登録
    public function registSubmit($request, $filePath){
        DB::table('products')->insert([
            'product_name' => $request->input('product_name'),
            'maker_name' => $request->input('maker_name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            'img_path' => $filePath,
            
        ]);
    }

    //検索
    public function search($keyword, $category){
        $query=DB::table('products')
        
        ->join('makers','products.maker_name','=','makers.id')
            ->select('products.*','makers.str as maker_name');


        if(!empty($category)) {
            $query->where('maker_name', 'LIKE', $category);
        }

        if(!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
        }
        $query->orderBy('products.id','ASC');
        $products = $query->get();
        return $products;
    }

    //更新(画像ある時)
    public function registEdit($request, $id, $filePath){
        DB::table('products')
        ->where('products.id','=', $id)
        ->update([
            'product_name' => $request->input('product_name'),
            'maker_name' => $request->input('maker_name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            'img_path' => $filePath,
        ]);
    }
    
    //更新(画像ない時)
    public function registEditNoImg($request, $id){
        DB::table('products')
        ->where('products.id','=', $id)
        ->update([
            'product_name' => $request->input('product_name'),
            'maker_name' => $request->input('maker_name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            
            
        ]);
    }

    

}

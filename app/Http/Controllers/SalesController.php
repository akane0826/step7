<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;
use Throwable;

class SalesController extends Controller
{
    public function buy(Request $request)
    {
        $product_model = new product();
        $sale_model = new sale();

        $id = $request->input('product_id');
        $pr = $product_model->getProductById($id);

        // 商品がない、在庫がない場合
        if (!$pr) {
            return response()->json('商品がありません');
        }
        if ($pr->stock <= 0) {
            return response()->json('在庫がありません');
        }

        try {
            DB::beginTransaction();
            //productsテーブルの在庫減らす
            $buy = $sale_model->decStock($id);
            //salesテーブルにインサート
            $sale_model->registSale($id);
        
            DB::commit();    
        } catch (Throwable $e){
            DB::rollBack();
        }

        //購入処理後の情報を返却
        return response()->json($buy);
        
    }
}

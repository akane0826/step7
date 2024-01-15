<?php

namespace App\Http\Controllers;

use App\Models\Maker;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index(Request $request)
    {
        //検索フォームに入力された値を取得
        $keyword = $request->input('keyword');
        $category = $request->input('category');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');
        $min_stock = $request->input('min_stock');
        $max_stock = $request->input('max_stock');

        
        
        $model = new Product;
        $products=$model->search($keyword, $category, $min_price, $max_price, $min_stock, $max_stock);
        
        //$products = Product::latest()->paginate(5);
        
        $makers = Maker::all();


        return view('index',compact('products','category','keyword','min_price','max_price','min_stock','max_stock','makers'));
            //->with('makers',$makers,'i',(request()->input('page',1)-1)*5);
            
            
           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $makers = Maker::all();
        return view('create')
            ->with('makers',$makers);
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
            'product_name' => 'required|max:20',
            'maker_name' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'nullable|max:150',
            'img_path' => 'nullable|image|max:2048',
            ]);

        DB::beginTransaction();
        try{
            
        
            $product = new Product;
            //$product->product_name = $request->input(["product_name"]);
            //$product->maker_name = $request->input(["maker_name"]);
            // $product->price = $request->input(["price"]);
            // $product->stock = $request->input(["stock"]);
            // $product->comment = $request->input(["comment"]);
            //$product->img_path = $request->input(["img_path"]);
           

            if($request->hasFile('img_path')){
            $filename = $request->file('img_path')->getClientOriginalName();
            $request->file('img_path')->storeAs('public/images',$filename);
            $filePath = 'storage/images/' . $filename;
            }else{
                $filePath = null;
            }
            $product->registSubmit($request, $filePath);
            // $product->save();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
        }
        
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $makers = Maker::all();
        return view('show',compact('product'))
            ->with('makers',$makers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $product = Product::find($id);
        $makers = Maker::all();
        return view('edit',compact('product'))
            ->with('makers',$makers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'product_name' => 'required|max:20',
            'maker_name' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'nullable|max:200',
            'img_path' => 'nullable|image|max:2048',
         ]);
        DB::beginTransaction();
        try{
            $productModel = new Product;
            
            // $product->product_name = $request->input(["product_name"]);
            // $product->maker_name = $request->input(["maker_name"]);
            // $product->price = $request->input(["price"]);
            // $product->stock = $request->input(["stock"]);
            // $product->comment = $request->input(["comment"]);
            // $product->img_path = $request->input(["img_path"]); 

            if($request->hasFile('img_path')){
            $filename = $request->file('img_path')->getClientOriginalName();
            $request->file('img_path')->storeAs('public/images',$filename);
            $filePath = 'storage/images/' . $filename;
            $productModel->registEdit($request, $id, $filePath);
            }else{
                $filePath = null;
                $productModel->registEditNoImg($request, $id);
            }
                      
            //$product->save();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try{
            $product->delete();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('products.index')
                        ->with('success',$product->product_name.'を削除しました');
    }

    
}

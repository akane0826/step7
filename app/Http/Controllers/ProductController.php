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
        
        
        
        //$products = Product::latest()->paginate(5);
        $query = Product::query();
        $query->join('makers','products.maker_name','=','makers.id')
            ->select('products.*','makers.str as maker_name');
        
            
           

        

        

        if(!empty($category)) {
            $query->where('maker_name', 'LIKE', $category);
        }

        if(!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
        }
        $query->orderBy('products.id','ASC');
        $products = $query->get();

        $makers = Maker::all();

        return view('index',compact('products','category','keyword','makers'));
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
        DB::beginTransaction();
        try{
            $request->validate([
            'product_name' => 'required|max:20',
            'maker_name' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'nullable|max:150',
            'img_path' => 'nullable|image|max:2048',
            ]);
        
            $product = new Product;
            $product->product_name = $request->input(["product_name"]);
            $product->maker_name = $request->input(["maker_name"]);
            $product->price = $request->input(["price"]);
            $product->stock = $request->input(["stock"]);
            $product->comment = $request->input(["comment"]);
            //$product->img_path = $request->input(["img_path"]);
            

            if($request->hasFile('img_path')){
            $filename = $request->file('img_path')->getClientOriginalName();
            $filePath = $request->file('img_path')->storeAs('public/images',$filename);
            $product->img_path = 'storage/images/' . $filename;
            }
        
            $product->save();
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
    public function edit(Product $product)
    {
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
    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                'product_name' => 'required|max:20',
                'maker_name' => 'required|integer',
                'price' => 'required|integer',
                'stock' => 'required|integer',
                'comment' => 'nullable|max:200',
                'img_path' => 'nullable|image|max:2048',
             ]);
        
            $product->product_name = $request->input(["product_name"]);
            $product->maker_name = $request->input(["maker_name"]);
            $product->price = $request->input(["price"]);
            $product->stock = $request->input(["stock"]);
            $product->comment = $request->input(["comment"]);
            $product->img_path = $request->input(["img_path"]);
            $product->save();
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

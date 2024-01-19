@extends('app')
  
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="text-left">
                <h1 style="font-size:2rem;">商品一覧画面</h1>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        @if($message = Session::get('success'))
            <div class="alert alert-success mt-1"><p>{{$message}}</p></div>
        @endif
        </div>
    </div>
    
    
    <div class="search">
        <form action="{{ route('products.index') }}" method="GET" id="search-form">
            @csrf
            <row class="form-group">
                <td>                   
                    <div>
                        <input type="text" name="keyword" placeholder="検索キーワード" value="{{ $keyword }}">
            
                        <select name="category" data-toggle="select">
                            <option value="">メーカー名</option>
                            @foreach ($makers as $maker)
                                <option value="{{ $maker->id }}" @if($maker->str=='{{ $maker->id }}') selected @endif>{{ $maker->str }}</otion>
                            @endforeach
                        </select> 
                    </div>
                </td>

                <td>
                    <div>
                        <input type="number" name="min_price" placeholder="価格下限" value="{{ $min_price }}">
                        <span class="col-auto">~</span>
                        <input type="number" name="max_price" placeholder="価格上限" value="{{ $max_price }}">
                    </div>
                </td>

                <td>
                    <div>
                        <input type="number" name="min_stock" placeholder="在庫下限" value="{{ $min_stock }}">
                        <span class="col-auto">~</span>
                        <input type="number" name="max_stock" placeholder="在庫上限" value="{{ $max_stock }}">
                    </div>
                </td>

                <div>
                    <input type="submit" class="search-btn" value="検索">
                </div>

            </row>
        </form>
    </div>

    <div>
    <a class="btn btn-success" href="{{ route('product.create') }}">新規登録</a>
    </div>

    

    <div id="products-table">
        <table class="table table-bordered" id="pr-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>      
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                
                <tr>
                    <td style="text-align:right">{{ $product->id }}</td>
                    <td>
                        <img src="{{ asset($product->img_path) }}" width="100">
                    </td>
                    <td style="text-align:right">{{ $product->product_name }}</td>
                    <td style="text-align:right">￥{{ $product->price}}</td>
                    <td style="text-align:right">{{ $product->stock }}</td>
                    <td style="text-align:right">{{ $product->maker_name }}</td>
                    <td style="text-align:center">
                        <a class="btn btn-primary" href="{{ route('product.show',$product->id) }}">詳細</a>
                    </td>
                    <td style="text-align:center">
                        <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-sm btn-danger delete-btn" value="削除" data-delete_id="{{ $product->id }}" ></input>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
    
 
@endsection
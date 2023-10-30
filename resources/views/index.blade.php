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
        <form action="{{ route('products.index') }}" method="GET">
            @csrf
            <row class="form-group">
                <td>
                    <label for="">
                    <div>
                        <option value="">検索キーワード</option>
                        <input type="text" name="keyword" value="{{ $keyword }}">
                    </div>
                    </label>
                </td>

                <td>
                    <label for="">
                    <div>
                        <select name="category" data-toggle="select">
                            <option value="">メーカー名</option>
                            @foreach ($makers as $maker)
                                <option value="{{ $maker->id }}" @if($maker->str=='{{ $maker->id }}') selected @endif>{{ $maker->str }}</otion>
                            @endforeach
                        </select> 
                    </div>
                    </label>
                </td>

                <td>
                    <input type="submit" class="btn" value="検索">
                </td>

            </row>
        </form>
    </div>
    


    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            <th style="text-align:center">
                <a class="btn btn-success" href="{{ route('product.create') }}">新規登録</a>
            </th>
            
        </tr>
        @foreach ($products as $product)
        
        <tr>
            <td style="text-align:right">{{ $product->id }}</td>
            <td>
                <img src="{{ asset($product->img_path) }}" alt="商品画像" width="100">
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
                    <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか？");'>削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
 
    
 
@endsection
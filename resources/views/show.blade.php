@extends('app')
   
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 style="font-size:2rem;">商品情報詳細画面</h2>
        </div>
    </div>
</div>
 
<table class="table table-bordered">
        <tr>
            <td>ID</td>
            <td>{{ $product->id }}</td>
        </tr>
        <tr>
            <td>商品画像</td>
            <td>{{ $product->img_path }}</td>
        </tr>
        <tr>
            <td>商品名</td>
            <td>{{ $product->product_name }}</td>
        </tr>
        <tr>
            <td>メーカー</td>
            <td>
                @foreach ($makers as $maker)
                    @if($maker->id==$product->maker_name){{ $maker->str }}@endif
                @endforeach
            </td>
        </tr>
        <tr>
            <td>価格</td>
            <td>{{ $product->price }}</td>
        </tr>
        <tr>
            <td>在庫数</td>
            <td>{{ $product->stock }}</td>
        </tr>
        <tr>
            <td>コメント</td>
            <td>{{ $product->comment }}</td>
        </tr>
</table>

<div class="row">
    <row>
        <td style="text-align:left">       
            <a class="btn btn-primary" href="{{ route('product.edit',$product->id) }}">編集</a>
        </td>
        <td>
            <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
        </td>
    </row>
</div>
@endsection

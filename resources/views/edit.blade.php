@extends('app')
   
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 style="font-size:2rem;">商品情報編集画面</h2>
        </div>
    </div>
</div>
 
<div style="text-align:left;">
<form action="{{ route('product.update',$product->id) }}" method="POST" enctype='multipart/form-data'>
    @method('PUT')
    @csrf
     
    <table class="table table-bordered">
        <tr>
            <td>ID</td>
            <td>{{ $product->id }}</td>
        </tr>
        <tr>
            <td>商品名<span style="color:red;">*</span></td>
            <td>
                <input type="text" name="product_name" value="{{$product->product_name}}" class="form-control" placeholder="商品名">
                @error('product_name')
                <span style="color:red;">名前を20文字以内で入力してください</span>
                @enderror
            </td>
        </tr>
        <tr>
            <td>メーカー名<span style="color:red;">*</span></td>
            <td>
                <select name="maker_name" class="form-select">
                    <option>メーカー名</otion>
                    @foreach ($makers as $maker)
                        <option value="{{ $maker->id }}"@if($maker->id==$product->maker)selected @endif>{{ $maker->str }}</otion>
                    @endforeach
                </select>
                @error('maker_name')
                <span style="color:red;">メーカー名を選択してください</span>
                @enderror
            </td>
        </tr>
        <tr>
            <td>価格<span style="color:red;">*</span></td>
            <td>
                <input type="text" name="price" value="{{$product->price}}" class="form-control" placeholder="価格">
                @error('price')
                <span style="color:red;">価格を数値で入力してください</span>
                @enderror
            </td>
        </tr>
        <tr>
            <td>在庫数<span style="color:red;">*</span></td>
            <td>
                <input type="text" name="stock" value="{{$product->stock}}" class="form-control" placeholder="在庫数">
                @error('stock')
                <span style="color:red;">在庫数を数値で入力してください</span>
                @enderror
            </td>
        </tr>
        <tr>
            <td>コメント</td>
            <td>
                <textarea class="form-control" style="height:100px" name="comment" placeholder="コメント">{{$product->comment}}</textarea>
                @error('comment')
                <span style="color:red;">コメントは200字以内で入力してください</span>
                @enderror
            </td>
        </tr>
        <tr>
            <td>商品画像</td>
            <td>
                
                    <input type="file" name="img_path">
                
            </td>
        </tr>
    </table>

    <div class="row">
        <row>
            <td style="text-align:left"> 
                <button type="submit" class="btn btn-primary">更新</button>
            </td>
            <td>
                <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
            </td>
        </row>
    </div>
</form>
</div>
@endsection

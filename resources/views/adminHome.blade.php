@include('header')

<div class="mt-5">
    @if($errors->any())
        <div class="col-12">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif
</div>
<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
    <button type="button" class="btn btn-primary" onclick="window.location='{{route('product')}}'">Add New Product</button> <br>
</div>

<div class="table-responsive-lg">
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Image</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Category</th>
      <th scope="col">Price</th>
      <th scope="col">Stock</th>
      <th scope="col">Action</th>      
    </tr>
  </thead>
  <tbody>
    @foreach($products as $key => $product)
    <tr>
      <th scope="row">{{$key+1}}</th>
      <td><img alt="product" height="236" width="158" src="{{asset('images/item/'.$product->image)}}"></td>
      <td>{{$product->name}}</td>
      <td width="20%">{{$product->description}}</td>
      <td>{{$product->category_name}}</td>
      <td>{{$product->price}}</td>
      <td>{{$product->quantity}}</td>
      <td>
      <button type="button" class="btn btn-outline-primary" onclick="window.location='{{route('product.show', ['id' => $product->id])}}'">Edit</button><br>
      <button type="button" class="btn btn-outline-primary" onclick="window.location='{{route('product.delete', ['id' => $product->id])}}'">Remove</button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

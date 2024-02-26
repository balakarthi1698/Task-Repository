@include('header')

<div class="container">
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
    <form method="POST" action="{{ route('product.edit', ['id' => $product->id]) }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label for="item_name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Name" value="{{$product->name}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="{{$product->description}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="category_name new_category_name" class="col-sm-2 col-form-label">Category</label>
        <div class="form-group col-sm-8">
        <select  onchange="categoryNew()" id="category_name" name="category_name" class="form-control">
            <option selected value="">Choose...</option>
            @foreach($categories as $category)
                <option @if($product->category->name==$category->name) selected @endif value="{{$category->name}}">{{$category->name}}</option>
            @endforeach
            <option value="New">New Category</option>
        </select>
        <input type="text" class="form-control" id="new_category_name" name="new_category_name" placeholder="New Category" style="visibility: hidden;">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="price" class="col-sm-2 col-form-label">Price</label>
        <div class="col-sm-8">
        <input type="number" min="1" class="form-control" id="price" name="price" placeholder="Price in Rupee" value="{{$product->price}}">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="quantity" class="col-sm-2 col-form-label">Stock</label>
        <div class="col-sm-8">
        <input type="number" min="0" class="form-control" id="quantity" name="quantity" placeholder="Stock Count" value="{{$product->quantity}}">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="item_image" class="col-sm-2 col-form-label">Picture</label>
        <div class="col-sm-8">
        <input type="file" class="form-control" id="item_image" name="item_image" value="{{$product->image}}">
        </div>
    </div>
    <!-- <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
        <img src="{{asset('images/item/'.$product->image)}}" alt="product">
        </div>
    </div> -->

    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
        <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
    </form>
</div>

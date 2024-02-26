@include('header')

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <img src="" alt="product" id="image" width="140" height="150">
                        </div>
                    </div>
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" id="name" name="name" value="">
                        </div>
                    </div>
       
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <textarea readonly id="description" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" id="category" name="category" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" id="price" name="price" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="" value="1">
                        </div>
                    </div>
        
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Add to Cart
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap">
    @foreach($products as $product)
    <figure class="figure p-4" style="width: 250px;">
        <img alt="product" height="236" width="158" src="{{asset('images/item/'.$product->image)}}">
        <figcaption class="figure-caption text-wrap mt-1" style="font-size: 18px;font-weight:500;">{{$product->name}}</figcaption>
        <figcaption class="figure-caption text-wrap">{{$product->description}}</figcaption>
        <figcaption class="figure-caption text-wrap">Category: {{$product->category_name}}</figcaption>
        <figcaption class="figure-caption text-wrap" style="font-size: 20px;font-weight:500;">{{$product->price}}</figcaption>
        @if($product->quantity > 0)
        <figcaption class="figure-caption text-wrap mb-1 text-success">Stock Available</figcaption>
        <a class="my-popup" href="javascript:void(0)" id="{{$product->id}}">
            <button type="button" class="btn btn-primary">Add to cart</button>
        </a>
        @else
        <figcaption class="figure-caption text-wrap mb-1 text-danger">Stock not Available</figcaption>
        <button type="button" class="btn btn-primary" disabled>Add to cart</button>
        @endif
    </figure>
    @endforeach
</div>

<script type="text/javascript">
  $(function () {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    $('.my-popup').click(function () {
        var product_id = this.id;
        var imagePath = "<?= asset('images/item/') ?>";
        $.get("{{ route('product.data') }}" +'?id=' + product_id, function (data) {
            $('#modelHeading').html("Add to Cart");
            $('#saveBtn').val("add-to-cart");
            $('#ajaxModel').modal('show');
            $('#product_id').val(data.id);
            $('#image').attr('src', imagePath+'/'+data.image);
            $('#name').val(data.name);
            $('#description').val(data.description);
            $('#category').val(data.category.name);
            $('#price').val('₹'+data.price);
            $('#quantity').attr('max', data.quantity);
        });
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Adding..');
      
        $.ajax({
          data: $('#productForm').serialize(),
          url: "{{ route('addToCart') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              $('#productForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              $('#saveBtn').html('Add to Cart');
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Add to Cart');
          }
      });
    });
  });
</script>

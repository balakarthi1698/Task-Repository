@include('header')

<div class="table-responsive-lg">
<h4>User Cart</h4>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Description</th>
      <th scope="col">Price/Item</th>
      <th scope="col">Order Quantity</th>
    </tr>
  </thead>
  <tbody>
    @foreach($cart as $key => $item)
    <tr>
      <th scope="row">{{$key+1}}</th>
      <td>{{$item->categoryItem->name}}</td>
      <td>{{$item->categoryItem->description}}</td>
      <td>{{$item->categoryItem->price}}</td>
      <td>{{$item->quantity}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

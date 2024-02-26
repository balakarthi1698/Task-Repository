@include('header')

<div class="table-responsive-lg">
<h4>Users List</h4>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Gender</th>
      <th scope="col">Phone</th>
      <th scope="col">Address</th>     
    </tr>
  </thead>
  <tbody>
    @foreach($users as $key => $user)
    <tr>
      <th scope="row">{{$key+1}}</th>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>{{$user->gender}}</td>
      <td>{{$user->phone}}</td>
      <td>{{$user->address}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

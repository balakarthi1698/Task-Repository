@extends('app')

<div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
      <h5 class="text-white h4">Hi {{auth()->user()->first_name.' '.auth()->user()->last_name}}</h5>
      <span class="text-muted"><a href="{{route('home')}}">Home</a></span><br>
      <span class="text-muted"><a href="{{route('profile')}}">View Profile</a></span><br>
      @if(auth()->user()->is_admin)
      <span class="text-muted"><a href="{{route('userList')}}">View Users</a></span><br>
      @else
      <span class="text-muted"><a href="{{route('user.cart')}}">View Cart</a></span><br>
      @endif
      <span class="text-muted"><a href="{{route('logout')}}">Logout</a></span><br>
    </div>
  </div>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    @if(url()->current() == route('home'))
    <form class="form-inline" method="GET" action="{{ route('home') }}">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" name="q" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
  </form>
  @endif
  </nav>
</div>
<br>

@extends('layouts.app')
@section('content')
<div class="container">
   
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row col-md-12">
                        {{-- <div class="col-md-4">
                            <div class="card" style="width: auto;">
                                <div class="card-body">
                                    <h5 class="card-title">To Do List</h5>
                                    <p class="card-text">Tasks : {{$todo}}</p>
                                    <a href="{{url('/todolist')}}" class="btn btn-primary">To Do List</a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-4">
                            <div class="card" style="width: auto;">
                                <div class="card-body">
                                    <h5 class="card-title">Products </h5>
                                    <p class="card-text">Total Products : {{$prod}}</p>
                                    <a href="{{url('/products')}}" class="btn btn-primary">Products</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card" style="width: auto;">
                                <div class="card-body">
                                    <h5 class="card-title">Total</h5>
                                    <p class="card-text">Total Amount : Rs.{{$total->Total}}</p>
                                    <a href="{{url('/products')}}" class="btn btn-primary">Products</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card" style="width: auto;">
                                <div class="card-body">
                                    <h5 class="card-title">Orders</h5>
                                    <p class="card-text">Total Orders : {{$orders}}</p>
                                    <a href="{{url('/products')}}" class="btn btn-primary">Products</a>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


 


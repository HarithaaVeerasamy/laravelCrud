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
                   <table style="width: 100%">
                       <tr>
                           <td>
                                <div class="card" style="width: auto;">
                                    <div class="card-body">
                                        <h5 class="card-title">To Do List</h5>
                                        <p class="card-text">Tasks : {{$todo}}</p>
                                        <a href="{{url('/todolist')}}" class="btn btn-primary">To Do List</a>
                                    </div>
                                </div> 
                           </td>
                           <td>
                               <div class="card" style="width: auto;">
                                    <div class="card-body">
                                        <h5 class="card-title">Product List</h5>
                                        <p class="card-text">Products : {{$prod}}</p>
                                        <a href="{{url('/products')}}" class="btn btn-primary">Products</a>
                                    </div>
                                </div> 
                           </td>
                       </tr>
                   </table>
                        
                       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


 


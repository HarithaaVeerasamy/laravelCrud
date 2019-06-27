@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-4 pull-right">
        <a class="btn btn-primary" href = "{{url('home')}}">Products</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add Product</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                      <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                      </div><br />
                    @endif
                   {{  Form::open(array('url' => '/create','method'=>'POST','enctype'=>'multipart/form-data')) }}
                        <table class="table ">
                            <tr>
                                <td><label>Product Name</label></td>
                                <td>{{Form::text('product_name',null,['class'=>'form-control','placeholder'=>"Enter Product Name",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td> <label>Category</label></td>
                                <td>{{Form::text('category',null,['class'=>'form-control','placeholder'=>"Enter Product Category",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td> <label>Sub Category</label></td>
                                <td>{{Form::text('sub_category',null,['class'=>'form-control','placeholder'=>"Enter Product Sub Category",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td> <label>Quantity</label></td>
                                <td>{{Form::number('qty',null,['class'=>'form-control','placeholder'=>"Enter Product Quantity",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td> <label>Price</label></td>
                                <td>{{Form::text('price',null,['class'=>'form-control','placeholder'=>"Enter Product Price",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td> <label>Image</label></td>
                                <td>{{Form::file('image',null,['class'=>'form-control','placeholder'=>"Enter Product Image",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">{{ Form::submit("Create", ['class' => 'btn btn-primary btn-md']) }} 
                                     <a href="{{url('addProduct')}}" class="btn btn-danger">Cancel</a>
                                </td>
                               
                            </tr>
                        </table>
                    {{Form::close()}}   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

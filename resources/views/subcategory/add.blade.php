@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-4 pull-right">
        <a class="btn btn-primary" href = "{{url('subcategory')}}">Sub Category</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add SubCategory</div>

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
                   {{  Form::open(array('url' => '/create_subcategory','method'=>'POST')) }}
                        <table class="table ">
                            <tr>
                                <td><label>Category Name</label></td>
                                <td>
                                    @foreach($category as $cate)
                                        @php $array[$cate['category_id']] = $cate['category_name'] ; @endphp
                                    @endforeach
                                    {{ Form::select('cate_id',$array,  null, ['class' => 'form-control box-size', 'placeholder' =>"Select Category", 'required' => 'required']) }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Sub Category Name</label></td>
                                <td>{{Form::text('subcate_name',null,['class'=>'form-control','placeholder'=>"Enter Sub Category Name",'autocomplete'=>'off'])}}</td>
                            </tr>
                            
                            <tr>
                                <td colspan="2" style="text-align: center;">{{ Form::submit("Create", ['class' => 'btn btn-primary btn-md']) }} 
                                     <a href="{{url('addSubCategory')}}" class="btn btn-danger">Cancel</a>
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

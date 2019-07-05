@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-4 pull-right">
        <a class="btn btn-primary" href = "{{url('products')}}">Products</a>
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
                                <td>
                                   @foreach($category as $cate)
                                        @php $array[$cate['category_id']] = $cate['category_name'] ; @endphp
                                    @endforeach
                                    {{ Form::select('category',$array,  null, ['class' => 'form-control box-size', 'placeholder' =>"Select Category", 'required' => 'required','id'=>'Cate']) }}
                                </td>
                            </tr>
                            <tr>
                                <td> <label>Sub Category</label></td>
                                <td>
                                    <select name="sub_category" class="form-control" placeholder="Select SubCategory" id="SubCate">
                                        <option value="">Select SubCategory</option>
                                    </select>
                                </td>
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
<script type="text/javascript "src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $('#Cate').change(function(){
        var id   = $(this).val()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url("/select_subcate") }}',
            type: 'POST',
            data: {
                id: id
            }
        }).done(function(data){
            if(data){
                $('#SubCate').append(data);
            }
        });
    })
} );
</script>
@endsection

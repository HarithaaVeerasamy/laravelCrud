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
                   {{  Form::open(array('url' => '/update','method'=>'POST','enctype'=>'multipart/form-data')) }}
                        <table class="table ">
                            <tr>
                                @php print_r($data->product_name); @endphp
                                <td><label>Product Name</label></td>
                                <td>{{Form::text('product_name',$data->product_name,['class'=>'form-control','placeholder'=>"Enter Product Name",'autocomplete'=>'off'])}}
                                    {{Form::hidden('id',$data->id)}}
                                </td>
                            </tr>
                            <tr>
                                <td> <label>Category</label></td>
                                <td>
                                   @foreach($category as $cate)
                                        @php $array[$cate['category_id']] = $cate['category_name'] ; @endphp
                                    @endforeach
                                    {{ Form::select('category',$array, $data->category, ['class' => 'form-control box-size', 'placeholder' =>"Select Category", 'required' => 'required','id'=>'Cate']) }}
                                </td>
                            </tr>
                            <tr>
                                <td> <label>Sub Category</label></td>
                                <td>
                                   @php $array1 = array(); @endphp
                                     @foreach($subcategory as $sub)
                                        @php $array1[$sub['sub_id']] = $sub['subcate_name'] ; @endphp
                                    @endforeach
                                    {{ Form::select('sub_category',$array1, $data->sub_category, ['class' => 'form-control box-size', 'placeholder' =>"Select SubCategory", 'required' => 'required','id'=>'SubCate']) }}
                                </td>
                            </tr>
                            <tr>
                                <td> <label>Quantity</label></td>
                                <td>{{Form::number('qty',$data->qty,['class'=>'form-control','placeholder'=>"Enter Product Quantity",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td> <label>Price</label></td>
                                <td>{{Form::text('price',$data->price,['class'=>'form-control','placeholder'=>"Enter Product Price",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td> <label>Image</label><br/><span>(Leave empty for previous image)</span></td>
                                <td>{{Form::file('image',null,['class'=>'form-control','placeholder'=>"Enter Product Image",'autocomplete'=>'off'])}}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">{{ Form::submit("Update", ['class' => 'btn btn-primary btn-md']) }} 
                                     <a href="{{url('products')}}" class="btn btn-danger">Cancel</a>
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
                $('#SubCate').html(data);
            }
        });
    })
} );
</script>
@endsection

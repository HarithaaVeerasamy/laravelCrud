@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-4 pull-right">
        <a class="btn btn-primary" href = "{{url('Prodimages')}}"> Images</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Products & It's Images</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                          @if(Session::has('alert-' . $msg))

                          <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                          @endif
                        @endforeach
                      </div>
                       {{  Form::open(array('url' => '/createImage','method'=>'POST','enctype'=>'multipart/form-data')) }}
                        <table class="table ">
                            <tr>
                                <td><label>Product Name</label></td>
                                <td> @foreach($products as $cate)
                                        @php $array[$cate['id']] = $cate['product_name'] ; @endphp
                                    @endforeach
                                    {{ Form::select('product_id',$array,  null, ['class' => 'form-control box-size', 'placeholder' =>"Select Product", 'required' => 'required','id'=>'Cate']) }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Images</label></td>
                                <td> 
                                    <input type="file" name="filename[]" multiple="multiple">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">{{ Form::submit("Create", ['class' => 'btn btn-primary btn-md']) }} 
                                     <a href="{{url('addImage')}}" class="btn btn-danger">Cancel</a>
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
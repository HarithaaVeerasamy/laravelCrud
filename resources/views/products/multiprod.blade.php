@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-4 pull-right">
        <a class="btn btn-primary" href = "{{url('addImage')}}"> Add Image</a>
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
                      <table class="table table-brodered table-hover table-stripped" id="example"> 
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Product</th>
                                <th>Images</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $prod)
                            <tr>
                                <td>1</td>
                                <td>{{$prod->product_name}}</td>
                                <td>
                                    @php $images = explode(',',$prod->images); @endphp
                                    @foreach($images as $image)
                                    <img src="{!!  URL::to('/').'/'.$image  !!}" style="width: 90px">
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                          
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
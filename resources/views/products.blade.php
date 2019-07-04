@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-4 pull-right">
        <a class="btn btn-primary" href = "{{url('addProduct')}}"> Add Product</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Products</div>

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

                    <div class="table-responsive">
                        <table class="table table-brodered table-hover table-stripped" id="example">
                            <thead>
                                <th>S No</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>SubCategory</th>
                                <th>Quantity</th>
                                <th>Price (Rs.)</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @if(count($data) > 0)
                                @foreach($data as $prod)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$prod->product_name}}</td>
                                    <td>{{$prod->category}}</td>
                                    <td>{{$prod->sub_category}}</td>
                                    <td>{{$prod->qty}}</td>
                                    <td>{{$prod->price}}</td>
                                    <td>
                                        <img src="{!!  URL::to('/').'/'.$prod->image  !!}" alt="{{ $prod->image }}" style="width:50px;height: 50px;">
                                        
                                    </td>
                                    <td>{{($prod->status == 1)?'Active':'Inactive'}}</td>
                                    <td>
                                        <a href="{{url('/edit/'.$prod->id)}}" class="btn btn-info btn-sm">Edit </a>
                                        <a href="{{url('/delete/'.$prod->id)}}" class="btn btn-danger btn-sm">InActivate </a>
                                    </td>
                                </tr>
                                    @php $i++; @endphp
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" style="text-align: center;font-weight: bold;">No data Found</td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<script type="text/javascript "src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript "src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript "src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
@endsection


 


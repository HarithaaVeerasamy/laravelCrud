@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-4 pull-right">
        <a class="btn btn-primary" href = "{{url('addCategory')}}"> Add Category</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Category</div>

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
                               
                                <th>Category</th>
                               
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @if(count($data) > 0)
                                @foreach($data as $cate)
                                <tr>
                                    <td>{{$i}}</td>
                                
                                    <td>{{$cate->category_name}}</td>
                                    
                                    
                                    <td>{{($cate->status == 1)?'Active':'Inactive'}}</td>
                                    <td>
                                        <a href="{{url('/edit_category/'.$cate->category_id)}}" class="btn btn-info btn-sm">Edit </a>
                                        @if($cate->status == 1)
                                        <a href="{{url('/delete_category/'.$cate->category_id)}}" class="btn btn-danger btn-sm">InActivate </a>
                                        @elseif($cate->status == 0)
                                        <a href="{{url('/activate_category/'.$cate->category_id)}}" class="btn btn-primary btn-sm">Activate </a>
                                        @endif
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

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Check Out</div>
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
                  @foreach($data as $order)
                      <br/>
                      <h4><b>Order Status</b> - #  {{$order->order_id}}</h4>
                      <table class="table table-brodered table-hover table-stripped">
                          <tr>
                              <td>Product</td>
                              <td>Qty</td>
                              <td>Price</td>
                              <td>Ordered Date</td>
                              
                          </tr>
                          <tr>
                              <td>{{$order->product_name}}</td>
                              <td>{{$order->quantity}}</td>
                              <td>{{$order->sub_total}}</td>
                              <td>{{date('d-m-Y',strtotime($order->created_at))}}</td>
                          </tr>
                      </table>
                            <div class="progress">
                              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 75%">Dispatched For Delivery</div>
                            </div>
                            <hr/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
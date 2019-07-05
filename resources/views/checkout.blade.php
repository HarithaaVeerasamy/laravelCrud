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
                    <div class=" row col-md-12">
                          <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Check Out</div>
                                <div class="card-body">
                                    <h4><b>Shipping Address</b></h4>
                                    <table class="table table-brodered  table-stripped">
                                        <tr>
                                            <td>Door No/Flat No<br/>
                                                <input type="text" name="door_no" class="form-control" placeholder="Door Numer">
                                            </td>
                                            <td>
                                                Street/Village
                                                <input type="text" class="form-control" placeholder="Street/Village" name="street">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                City
                                                <input type="text" class="form-control" placeholder="City" name="city">
                                            </td>
                                             <td>
                                                Pincode
                                                <input type="text" class="form-control" placeholder="Pincode" name="pincode">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center;">
                                                <a href="/order" class="btn btn-success" style="width: -webkit-fill-available;"> Proceed</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">Cart Items</div>
                                <div class="card-body">
                                    <h4><b>Your Order</b></h4>
                                        <table class="table table-brodered table-hover table-stripped">
                                            <thead>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $prod)
                                                <tr>
                                                    <td>{{$prod->product_name}}  </td>
                                                    <td>{{$prod->quantity}}</td>
                                                    <td>{{$prod->sub_total}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="2">Total</td>
                                                    <td>{{$total->total}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

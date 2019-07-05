@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Your Cart</div>
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
                                    <tr>
                                        <th>S.No</th>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Sub Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i =1;  @endphp
                                    @if(@count($data) >0)
                                    @foreach($data as $prod)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                            <img src="{!!  URL::to('/').'/'.$prod['image']  !!}" alt="{{ $prod['image'] }}" style="width:50px;height: 50px;">
                                        </td>
                                        <td><h3>{{$prod['product_name']}}</h3>
                                            <p>Category: {{$prod['category']}} <br/> 
                                            Sub Category: {{$prod['sub_category']}}</p>
                                           
                                        </td>
                                        <td>{{$prod['price']}}
                                            <input type="hidden" name="product_id" id="product_id-{{$prod['id']}}" value="{{$prod['product_id']}}">
                                        </td>
                                        <td><input type="number" name="qty" value="{{$prod['quantity']}}" class="form-control" style="width: 100px;" id='qty-{{$prod['id']}}' min="0" max="{{$prod['qty']}}"></td>
                                        <td>{{$prod['sub_total']}}</td>
                                        <td>
                                            <a href="{{url('/delete_cart/'.$prod['id'])}}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                   

                                    @php $i++; @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="5" style="text-align: right;"><b>Total</b> Rs.</td>
                                        <td>{{$total->total}}</td>
                                        <td></td>
                                    </tr>
                                     @else
                                        <tr>
                                            <td colspan="7" style="text-align: center;"> Your Cart is Empty!</td>
                                        </tr>
                                    @endif
                                    
                                </tbody>
                            </table>
                            <a class="btn btn-secondary" style="float: left" href="/display">Go to shopping</a>
                            <a class="btn btn-danger" style="float:right;" href="/checkout">Check Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript "src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script  type="text/javascript">
$(document).ready(function() {
  $('#updateCart').click(function(){
    alert();
  })
   $("body").on("change","[id^='qty-']", function(event){
        var id   = this.id;
        var qty  = $(this).val()
        var sid  = new Array();
        sid      = (id.split("-"));
        sel_id   = sid[sid.length-1];
        var product_id = $('#product_id-'+sel_id).val();
        //alert(sel_id+"::"+qty+"::"+product_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url("/update_cart") }}',
            type: 'POST',
            data: {
                sel_id: sel_id,
                qty : qty,
                product_id:product_id
            }
        }).done(function(data){
            if(data){
                location.reload();
            }
        });

    });
});
</script>
@endsection

    
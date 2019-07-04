@extends('layouts.app')
@section('content')

    <div class="container">
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
                        @php $i=0; $row = "";
                          $row .= "<div class='row col-md-12'>"; @endphp

                        @foreach($data as $prod)
                            @php 
                                $row .= "<div class='col-md-4'>";
                                    $row .= "<div class='card' style='margin-bottom: 20px;'>";
                                        $row .="<div class='card-header'>".$prod['product_name']."</div>";
                                        $row .="<div class='card-body'>";
                                            $row .="<img src=".URL::to('/').'/'.$prod['image'] ." alt=".$prod['image']."  class='center'>";
                                            $row .="<h3>".$prod['product_name']."</h3>";
                                            $row .="<p> Rs.".$prod['price']."</p>";
                                            $row .= "<div class='row col-md-12'>";
                                            $row .="<div class='col-md-6'><button class='btn btn-primary'>Buy</button></div>";
                                            $row .="<div class='col-md-6'><a class='btn btn-secondary ' href='".url('/add_to_cart/'.$prod['id'])."'>Add to Cart</a></div>";
                                            $row .="</div>";

                                        $row .= "</div>";

                                    $row .= "</div>";
                                
                                $row .= "</div>";
                                $i++;
                            @endphp
                         
                        @endforeach
                        @php $row .= "</div>"; echo $row;@endphp
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
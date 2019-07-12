<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductModel;
use Illuminate\Support\Facades\Validator;
use App\Task;
use App\CartModel;
use App\OrderModel;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    //Dashboard
    public function index()
    {
        if(auth()->user()->is_admin == 1){
            $data = ProductModel::count();
            $todo = Task::count();
            $sub_total = OrderModel::select(DB::Raw('SUM(sub_total) as Total'))->whereMonth('created_at',date('m'))->first();
            $orders = OrderModel::whereMonth('created_at',date('m'))->count();
            return view('home',['prod' => $data,'todo'=>$todo,'total'=>$sub_total,'orders'=>$orders]);
        }else{
            return redirect()->route("display");
        }
        
    }
    
   

    public function DisplayProduct()
    {
        $data = ProductModel::where('status',1)->get();
        return view('product_display',['data'=>$data]);
    }

    //Product Cart
    public function cartView()
    {
        $data = CartModel::select('cart.quantity','cart.sub_total','product_name','category','sub_category','image','price','cart.id','products.id as product_id','products.qty')->join('products','products.id','=','cart.product_id')->where('user_id',auth()->id())->get();
        $total = CartModel::select(DB::Raw('SUM(sub_total) as total'))->where('user_id',auth()->id())->first();
        return view('cart',['data' => $data,'total'=>$total]);
    }
    public function addToCart($id, Request $request)
    {
        $get_price = ProductModel::where('id',$id)->first();
        $data = [
            'user_id' => auth()->id(),
            'product_id' => $id,
            'quantity' => 1,
            'sub_total' => $get_price->price
        ];
        $checkCart = CartModel::where(['product_id' => $id,'user_id'=>auth()->id()])->first();
        if(count($checkCart) == 0){
            $create = CartModel::insertGetId($data);
        }else{
            $sub_total = $checkCart->sub_total + $get_price->price;
            $quantity  = $checkCart->quantity +1;
            $create = CartModel::where(['product_id' => $id,'user_id'=>auth()->id()])->update(['quantity'=>$quantity,'sub_total'=>$sub_total]);
        }
        if($create){
            $request->session()->flash('alert-success', 'Product added Successfully!');
            return back();
        }else{
            $request->session()->flash('alert-danger', 'Error while Adding!');
            return redirect()->route("display");
        }
    }

    public function deleteCart($id, Request $request)
    {
        $delete = CartModel::where('id',$id)->delete();
        $data = CartModel::select('cart.quantity','cart.sub_total','product_name','category','sub_category','image','price','cart.id','products.id as product_id','products.qty')->join('products','products.id','=','cart.product_id')->where('user_id',auth()->id())->get();
        $total = CartModel::select(DB::Raw('SUM(sub_total) as total'))->where('user_id',auth()->id())->first();
        $request->session()->flash('alert-danger', 'Product Successfully Deleted From Your Cart!');
         return view('cart',['data' => $data,'total'=>$total]);
        //return redirect()->route("cart");
    }

    public function updateCart(Request $request)
    {
        $qty        =  $request['qty'];
        $cart_id    = $request['sel_id'];
        $product_id = $request['product_id'];
        // echo $product_id;
        $get_product_price = ProductModel::select('price')->where('id',$product_id)->first();
        $price = $get_product_price->price;
        $sub_total = $price * $qty;
        $data1 = [
            'quantity' => $qty,
            'sub_total' => $sub_total
        ];
        $update = CartModel::where('id',$cart_id)->update($data1);
        echo $cart_id;
    }

    public function checkout()
    {
        $data = CartModel::join('products','products.id','=','cart.product_id')->where('user_id',auth()->id())->get();
        $total = CartModel::select(DB::Raw('SUM(sub_total) as total'))->where('user_id',auth()->id())->first();
        return view('checkout',['data'=>$data,'total'=>$total]);
    }
    public function order(Request $request)
    {
        $get_cart = CartModel::where('user_id',auth()->id())->get();
        // print_r($get_cart);
       $order_id = substr(md5(time()), 0, 8);
       foreach ($get_cart as $key => $value) {
           $data = [
            'order_id' => $order_id,
            'user_id' => auth()->id(),
            'product_id' => $value['product_id'],
            'quantity' => $value['quantity'],
            'sub_total' => $value['sub_total'],
            'created_at' => date('Y-m-d H:i:s')
           ];
           $create = OrderModel::insertGetId($data);
           $delete = CartModel::where('product_id',$value['product_id'])->where('user_id',auth()->id())->delete();
           $get_qty = ProductModel::select('qty')->where('id',$value['product_id'])->first();
           //print_r($get_qty);die;
           $qty = $get_qty->qty - $value['quantity'];

           ProductModel::where('id',$value['product_id'])->update(['qty'=>$qty]);
       }
       $request->session()->flash('alert-success', 'Order Placed Successfully!');
       $get_order_id = OrderModel::where('user_id',auth()->id())->orderBy('id', 'desc')->first();
       return view('trackorder',['order_id' =>$get_order_id]);
    }

    public function myOrders()
    {
        $data = OrderModel::select('order_id','quantity','sub_total','product_name','order.created_at')->join('products','products.id','=','order.product_id')->where('user_id',auth()->id())->get();
        return view('myorder',['data'=>$data]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductModel;
use Illuminate\Support\Facades\Validator;
use App\Task;
use App\CartModel;
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
        $data = ProductModel::count();
        $todo = Task::count();

        return view('home',['prod' => $data,'todo'=>$todo]);
    }
    public function products()
    {
        $data = ProductModel::get();
        return view('products',['data' => $data]);
    }
    public function addProduct()
    {
        return view('addProduct');
    }
    public function create(Request $request)
    {
        $path = "";
        if(!empty($request->file('image'))){
            $image           = $request->file('image');
            $path            = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $path);
        }
       
        $input = [
            'product_name' => $request['product_name'],
            'category'     => $request['category'],
            'sub_category' => $request['sub_category'],
            'qty'          => $request['qty'],
            'price'        => $request['price'],
            'image'        => 'images/'.$path,
            'status'       => 1,
            'cretaed_by'   => auth()->id(),
            'updated_by'   => auth()->id(),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];
        $rules = [
            'product_name' => 'required',
            'category'     => 'required',
            'sub_category' => 'required',
            'qty'          => 'required |numeric',
            'price'        => 'required',
           
        ];
        $messages = [
                        'product_name' => 'The Product Name field is required.',
                        'category'     => 'The Category field is required.',
                        'sub_category' => 'The Sub Category field is required.',
                        'qty'          => 'The Quantity field is required.',
                        'price'        => 'The Price field is required',
                       
                    ];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return view('addProduct',['errors'=>$errors]);
        }

        $create = ProductModel::insertGetId($input);
        if($create){
            $request->session()->flash('alert-success', 'Product added Successfully!');
            return redirect()->route("home");
        }else{
            $request->session()->flash('alert-danger', 'Error while Adding!');
            return redirect()->route("home");
        }
    }
    public function delete($id, Request $request)
    {
        $delete = ProductModel::where('id',$id)->update(['status'=>0]);
        $request->session()->flash('alert-danger', 'Product Successfully InActivated!');
        return redirect()->route("home");
    }
    public function edit($id)
    {
        $data = ProductModel::where('id',$id)->first();
        return view('editProduct',['data' => $data]);
    }

    public function update(Request $request)
    {
        $data = [
            'product_name' => $request['product_name'],
            'category'     => $request['category'],
            'sub_category' => $request['sub_category'],
            'qty'          => $request['qty'],
            'price'        => $request['price'],
        ];
         if(!empty($request->file('image'))){

            $image           = $request->file('image');
            $path            = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $path);
            $data['image']   = 'images/'.$path;
        }
        $id = $request['id'];
        $update = ProductModel::where('id',$id)->update($data);
        if($update){
            $request->session()->flash('alert-success', 'Product Updated Successfully!');
            return redirect()->route("home");
        }else{
            $request->session()->flash('alert-danger', 'Error while Updating!');
            return redirect()->route("home");
        }
    }

    public function DisplayProduct()
    {
        $data = ProductModel::get();
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
        $create = CartModel::insertGetId($data);

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
}

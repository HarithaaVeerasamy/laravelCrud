<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductModel;
use Illuminate\Support\Facades\Validator;
use App\Task;
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
}

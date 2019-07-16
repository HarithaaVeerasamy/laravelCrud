<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProductModel;
use App\CategoryModel;
use App\SubCategoryModel;
use App\ImageModel;
use DB;
class Products extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = ProductModel::select('products.id','product_name','qty','price','image','products.status','category.category_name','subcategory.subcate_name')->join('category','category.category_id','=','products.category')->join('subcategory','subcategory.sub_id','=','products.sub_category')->get();
        return view('products.products',['data' => $data]);
    }
    public function addProduct()
    {
        $category = CategoryModel::where('status',1)->get();
       
        return view('products.addProduct',['category'=>$category]);
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
            return view('products.addProduct',['errors'=>$errors]);
        }

        $create = ProductModel::insertGetId($input);
        if($create){
            $request->session()->flash('alert-success', 'Product added Successfully!');
            return redirect()->route("products");
        }else{
            $request->session()->flash('alert-danger', 'Error while Adding!');
            return redirect()->route("products");
        }
    }
    public function delete($id, Request $request)
    {
        $delete = ProductModel::where('id',$id)->update(['status'=>0]);
        $request->session()->flash('alert-danger', 'Product Successfully InActivated!');
        return redirect()->route("products");
    }
    public function edit($id)
    {
        $data = ProductModel::where('id',$id)->first();
        $category = CategoryModel::where('status',1)->get();
        $subcategory = SubCategoryModel::where('cate_id',$data->category)->get();
        return view('products.editProduct',['data' => $data,'category'=>$category,'subcategory'=>$subcategory]);
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
            return redirect()->route("products");
        }else{
            $request->session()->flash('alert-danger', 'Error while Updating!');
            return redirect()->route("products");
        }
    }

    public function selectSub(Request $request)
    {
        $cate_id = $request['id'];
        $where = ['cate_id' => $cate_id,'status'=>1];
        $sub_cate = SubCategoryModel::where($where)->get();
        $option = "";
        foreach ($sub_cate as $key => $value) {
            $option .="<option value=".$value['sub_id'].">".$value['subcate_name']."</option>";
        }
        echo $option;
    }
    public function activate($id, Request $request)
    {
        $delete = ProductModel::where('id',$id)->update(['status'=>1]);
        $request->session()->flash('alert-success', 'Product Successfully Activated!');
        return redirect()->route("products");
    }


    //Multiple images Upload
    public function images()
    {
        $data = ImageModel::select(DB::raw('DISTINCT group_concat(image_path) as images'),'product_name')->join('products','products.id','=','images.product_id')->groupby('product_id')->get();
        return view('products.multiprod',['data'=>$data]);
    }

    public function addImage()
    {
        $get_products = ProductModel::select('id','product_name')->where('status',1)->get();
        return view('products.addimage',['products'=>$get_products]);
    }

    public function createImage(Request $request)
    {
        if($request->file('filename')){
            foreach ($request->file('filename') as $key=> $image) {

                $path            = time().'.'.$key.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/'.$request['product_id']);
                $image->move($destinationPath, $path);
                $data['image_path'] = 'images/'.$request['product_id'].'/'.$path;
                $data['product_id'] = $request['product_id'];
                ImageModel::insert($data);
            }
        }
        $request->session()->flash('alert-success', 'Images Successfully Addedd!');
        // return response()->json(['success'=>'You have successfully upload file.']);
    }
}

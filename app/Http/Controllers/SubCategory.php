<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategoryModel;
use App\CategoryModel;
use Illuminate\Support\Facades\Validator;

class SubCategory extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = SubCategoryModel::select('subcate_name','subcategory.status','category_name','sub_id')->join('category','category.category_id','=','subcategory.cate_id')->get();
        return view('subcategory.index',['data' =>$data]);
    }
    public function addCategory()
    {
        return view('category.add');
    }
    public function add(Request $request)
    {
        $category = CategoryModel::where('status',1)->get();
        return view('subcategory.add',['category'=>$category]);
    }
    public function store(Request $request)
    {
        
        $rules = ['cate_id' => 'required','subcate_name' => 'required'];
        $messages = ['cate_id' => 'Category is Required','subcate_name' => 'Sub Category is Required'];
        $input = ['cate_id' => $request['cate_id'],'subcate_name'=>$request['subcate_name'],'status'=>1];
        $validator = Validator::make($input, $rules, $messages);
        $category = CategoryModel::where('status',1)->get();
        if ($validator->fails()) {
            $errors = $validator->errors();
            return view('subcategory.add',['errors'=>$errors,'category'=>$category]);
        }
        $create = SubCategoryModel::insertGetId($input);
        if($create){
            $request->session()->flash('alert-success', 'SubCategory added Successfully!');
           return redirect()->route("subcategory");
        }else{
            $request->session()->flash('alert-danger', 'Error while Adding!');
            return redirect()->route("subcategory");
        }
    }
    public function edit($id)
    {
         $category = CategoryModel::where('status',1)->get();
         $subcategory = SubCategoryModel::where('sub_id',$id)->first();
         return view('subcategory.edit',['category'=>$category,'subcategory'=>$subcategory]);
    }
    public function update(Request $request)
    {
        $data = ['cate_id' => $request['cate_id'],'subcate_name'=>$request['subcate_name']];
        $id = $request['id'];
        $update = SubCategoryModel::where('sub_id',$id)->update($data);
        if($update){
            $request->session()->flash('alert-success', 'SubCategory Updated Successfully!');
            return redirect()->route("subcategory");
        }else{
            $request->session()->flash('alert-danger', 'Error while Updating!');
            return redirect()->route("subcategory");
        }
    }
    public function delete($id, Request $request)
    {
        $delete = SubCategoryModel::where('sub_id',$id)->update(['status'=>0]);
        $request->session()->flash('alert-danger', 'SubCategory Successfully InActivated!');
        return redirect()->route("subcategory");
    }
    
    public function activate($id, Request $request)
    {
        $delete = SubCategoryModel::where('sub_id',$id)->update(['status'=>1]);
        $request->session()->flash('alert-success', 'SubCategory Successfully Activated!');
        return redirect()->route("subcategory");
    }

    public function multiple()
    {
        return view('multiple');
    }
    public function upload(Request $request)
    {
        $image_code = '';
        $images = $request->file('file');
        foreach($images as $image){
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/multiple'), $new_name);
            $image_code .= '<div class="col-md-3" style="margin-bottom:24px;"><img src="/images/multiple/'.$new_name.'" class="img-thumbnail" /></div>';
        }
        $output = array(
            'success'  => 'Images uploaded successfully',
            'image'   => $image_code
        );
        return response()->json($output);
    }
}

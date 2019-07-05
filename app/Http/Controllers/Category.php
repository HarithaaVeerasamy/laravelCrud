<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoryModel;
use Illuminate\Support\Facades\Validator;

class Category extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = CategoryModel::get();
        return view('category.index',['data' =>$data]);
    }
    public function addCategory()
    {
        return view('category.add');
    }
    public function storeCategory(Request $request)
    {
        
        $rules = ['category_name' => 'required'];
        $messages = ['category_name' => 'Category is Required'];
        $input = ['category_name' => $request['category_name'],'status'=>1];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return view('category.add',['errors'=>$errors]);
        }
        $create = CategoryModel::insertGetId($input);
        if($create){
            $request->session()->flash('alert-success', 'Category added Successfully!');
           return redirect()->route("category");
        }else{
            $request->session()->flash('alert-danger', 'Error while Adding!');
            return redirect()->route("category");
        }
    }
    public function edit($id)
    {
        $data = CategoryModel::where('category_id',$id)->first();
        return view('category.edit',['data'=>$data]);
    }
    public function update(Request $request)
    {
        $data = ['category_name' => $request['category_name']];
        $id = $request['id'];
        $update = CategoryModel::where('category_id',$id)->update($data);
        if($update){
            $request->session()->flash('alert-success', 'Category Updated Successfully!');
            return redirect()->route("category");
        }else{
            $request->session()->flash('alert-danger', 'Error while Updating!');
            return redirect()->route("category");
        }
    }
    public function delete($id, Request $request)
    {
        $delete = CategoryModel::where('category_id',$id)->update(['status'=>0]);
        $request->session()->flash('alert-danger', 'Category Successfully InActivated!');
        return redirect()->route("category");
    }
    
    public function activate($id, Request $request)
    {
        $delete = CategoryModel::where('category_id',$id)->update(['status'=>1]);
        $request->session()->flash('alert-success', 'Category Successfully Activated!');
        return redirect()->route("category");
    }
}

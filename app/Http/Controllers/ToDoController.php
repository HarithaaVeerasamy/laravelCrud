<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
class ToDoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = Task::get();
        return view('todolist',['data' =>$data]);
    }
    public function createtodo(Request $request)
    {
        $data = ['task_name' => $request['todo'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
                ];
        $insert = Task::insertGetId($data);
        if($insert){
            $request->session()->flash("alert-success","Task Created Successfully");
            return back();
        }else{
            $request->session()->flash("alert-danger","Error while creating");
             return back();
        }
    }
    public function deletetodo($id)
    {
        Task::where('id',$id)->delete();
        return back();
    }
    public function generatePDF()
    {
        $data = Task::get();
        $pdf = PDF::loadView('mypdf', ['data' =>$data]);
        return $pdf->download('todolist.pdf');
    }
    public function generateExcel()
    {
        $data = Task::get();
        $finalData = compact('data');
        Excel::create('todolist-'.strtotime(date('d-m-Y H:i:s')), function ($excel) use ($finalData) {
            $excel->sheet('todolist', function ($sheet) use ($finalData) {
                $sheet->loadView('mypdf', $finalData);
                $sheet->setAllBorders('thin');
            });
        })->store('xlsx', public_path('exports'))->download('xlsx');
    }
}

@extends('layouts.app')
@section('content')
<div class="container">
   
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create To Do </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Task</h3>
                    {{  Form::open(array('url' => '/create_todo','method'=>'POST')) }}
                    {{Form::text('todo',null,['class'=>'form-control','placeholder'=>"Enter Task",'autocomplete'=>'off'])}}
                    <br/>   
                    {{ Form::submit("Add Task", ['class' => 'btn btn-primary btn-md']) }}
                    {{Form::close()}}   
                </div>
            </div>
        </div>

        <div class="col-md-8" style="margin-top: 50px;">
            <div class="card">
                <div class="card-header">ToDo List </div>

                <div class="card-body">
                    <a href="/pdf" class="btn btn-primary ">PDF</a> &nbsp;&nbsp;&nbsp;
                    <a href="/excel" class="btn btn-primary ">excel</a>
                   <table class="table table-brodered table-hover table-stripped" style="width: 100%;text-align: center;">
                       <thead>
                           <tr>
                                <th>SNo</th>
                               <th>Task</th>
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                        @php $i=1; @endphp
                        @foreach($data as $task)
                           <tr>

                                <td>{{$i}}</td>
                                <td>{{$task->task_name}}</td>
                                <td><a href="{{url('/deletetodo/'.$task->id)}}" class="btn btn-danger btn-sm">delete</a></td>
                           </tr>
                           @php $i++; @endphp
                           @endforeach

                       </tbody>
                   </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
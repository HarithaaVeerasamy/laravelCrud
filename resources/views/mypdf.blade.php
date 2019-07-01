<!DOCTYPE html>

<html>

<head>

	<title>ToDo List</title>

</head>

<body>

	<table class="table table-brodered table-hover table-stripped" style="width: 100%;text-align: center;">
                       <thead>
                        <tr>
                            <td colspan="2">TO DO LIST</td>
                        </tr>
                           <tr>
                                <th>SNo</th>
                               <th>Task</th>
                               
                           </tr>
                       </thead>
                       <tbody>
                        @php $i=1; @endphp
                        @foreach($data as $task)
                           <tr>

                                <td>{{$i}}</td>
                                <td>{{$task->task_name}}</td>
                                
                           </tr>
                           @php $i++; @endphp
                           @endforeach

                       </tbody>
                   </table>
</body>

</html>
<style type="text/css">
    table,th,td{
        border: 1px solid black;
    }
</style>
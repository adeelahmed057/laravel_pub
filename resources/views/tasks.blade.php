@extends('layouts.app')

@section('content')

<!-- Bootstrap Boilerplate... -->


<div class="card border">
    <!-- Display Validation Errors -->
    @include('common')


    <!----------------Alert------------------>
    @if(Session::has('create'))
    <div class="alert alert-success">{{Session::get('create')}}</div>
    @endif

    @if(Session::has('delete'))
    <div class="alert alert-danger">{{Session::get('delete')}}</div>
    @endif

    <!----------------End Alert----------------------->

    <!-- New Task Form -->
    <form action="{{ route('tasks.store') }}" method="POST" class="form-horizontal g-3 needs-validation" nonvalidate>
        @csrf
        <div class="card-body">
            <!-- Task Name -->
            <h5 class="card-title">
                Create Task
            </h5>

            <div class="form-group">

                <label for="name">Task</label>
                <input type="text" name="name" id="task" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" value=" {{ old('name') }}">
                <div class="invalid-feedback">Please Enter Task</div>
                @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <!-----------------------------Date------------------------>

            <div class="form-group date" data-provide="datepicker">

                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control {{ $errors->first('date') ? 'is-invalid' : '' }}" data-date-format="yyyy/mm/dd" value="{{ old('date') }}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                    @if ($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                </div>
            </div>

            <!--------------------Time---------------------------->

            <div class="form-group">
                <label for="time">Time</label>
                <select class="form-control {{ $errors->first('time') ? 'is-invalid' : '' }}" name="time">
                    <option selected>Please Select Time</option>>
                    <option value="AM" {{ old('time') == 'AM' ? 'SELECTED' : '' }}>AM</option>
                    <option value="PM" {{ old('time')=='PM' ? 'SELECTED' : '' }}>PM</option>
                </select>
                @if ($errors->has('time'))
                <span class="text-danger">{{ $errors->first('time') }}</span>
                @endif
            </div>

            <!-- Add Task Button -->
            <button type="submit" vlaue="submit" class="btn btn-success">
                <i class="fa fa-plus"></i> Add Task
            </button>
        </div>
    </form>
</div>


@if (count($tasks) > 0)
<div class="panel panel-default pt-4">
    <div class="panel-heading p-3  border bg-light text-dark font-weight-bold">
        Current Tasks
    </div>

    <div class="panel-body border">
        <table class="table table-striped task-table table-bordered">

            <!-- Table Headings -->
            <thead>
                <th scope="col">Task</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th>&nbsp;</th>
            </thead>

            <!-- Table Body -->
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <!-- Task Name -->
                    <td class="table-text">
                        <div>{{ $task->name }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ $task->date }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ $task->time }}</div>
                    </td>

                    <td>
                        <form action="{{route('tasks.destroy', $task->id)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button class="btn btn-danger"><i class="fa-regular fa-trash-can"></i>
                                Delete Task
                            </button>
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endif
<!-- TODO: Current Tasks -->
@endsection

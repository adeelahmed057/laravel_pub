<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class TaskController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tasks = Task::orderBy('created_at', 'asc')->get();

        return view('tasks', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $date = $request->date;
        $time = $request->time;
        $validated = $request->validate(['name' => 'required|min:5',
            'date' => [
                'required',
                Rule::unique('tasks')->where(function ($query) use ($date, $time) {
                    return $query->where('date', $date)
                        ->where('time', $time);
                })
            ],
            'time' => 'required',

        ]);

        $task = new Task;
        $task->name = $request->name;
        $task->date = $request->date;
        $task->time = $request->time;
        $task->save();
        return back()->with('create', 'Task Has Been Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Task::findOrFail($id)->delete();
        return redirect('/tasks')->with('delete', 'Task Has Been Deleted');
    }
}

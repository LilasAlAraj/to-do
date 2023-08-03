<?php

namespace App\Http\Controllers;

use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'priority' => 'required|in:High,Middle,Low',
            'date' => 'required|date',
            'description' => 'required',
        ],
            [
                'name.required' => 'please enter a name of task',
                'name.max' => ' a name of task should be less than 50 characters',
                'date.required' => 'please enter a date of task',
                'date.date' => 'please enter a valid date of task',
                'description.required' => 'please enter a description of task',
                'priority.required' => 'please enter a priority of task',
                'priority.in' => 'priority should be select "High", "Middle", or "Low"}',
            ]);

        if ($validator->fails()) {
            // Return errors or redirect back with errors
            return $validator->errors();
        }

        $task = new task();
        $task->name = $request->name;
        $task->date = $request->date;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->status = false;
        $task->user_id=Auth::user()->id;
        if ($task->save()) {
            $id = task::latest()->first()->id;

            return response()->json(['status' => 'success', 'id' => $id, 'count' => task::count()]);
        } else {
            return response()->json(['status' => 'failed']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, task $task)
    {
        //
        $task = task::find($request->id);
        $task->status = !$task->status;
        $task->save();
        return response()->json($task->status);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (task::findOrFail($request->id)->delete()) {

            return response()->json(['status' => 'success']);
        } else {

            return response()->json(['status' => 'failed']);
        }

    }
}

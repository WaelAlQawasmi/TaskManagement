<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    const completedStatus = 'completed';
    const pendingStatus = 'pending';
     
    public function __construct() {
        $this->middleware('auth:api');  
        $this->middleware('CreatorTasksMiddleware')->only(["update", "destroy","AssignTask"]);  
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Task::paginate(15);
    }

    public function AssignTask(Request $request, $task){
        $task =Task::findOrFail( $task);
        $task =User::findOrFail($request->assignedUserId);
        $task->update(['assigned_user_id'=>$request->assignedUserId]); 
        return response()->json([
            'success' => true,
            'message' => ' Task Assigned successfully',
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'creator_user_id'=>Auth::id(),
            'status' =>self::pendingStatus,
        ]);

        return response()->json([
            'success' => true,
            'message' => ' Task created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($taskId)
    {
       return Task::findOrFail($taskId);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request,  $taskId)
    {
       $task= Task::findOrFail($taskId);
       $task->update($request->all());
       return response()->json('The task has been updated successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $taskId)
    {
        Task::findOrFail($taskId)->delete();
        return response()->json('The task has been deleted successfully', 204);

    }
}

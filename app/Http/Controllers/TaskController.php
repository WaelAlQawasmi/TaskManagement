<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Mail\NotificationEmail;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    const completedStatus = 'completed';
    const pendingStatus = 'pending';

    public function __construct()
    {
        $this->middleware('auth:api')->except(['getMyTasks']);
        $this->middleware('CreatorTasksMiddleware')->only(["update", "destroy", "AssignTask"]);
        $this->middleware('AdminMiddleware')->only(["index"]);
        $this->middleware('AssignedOrCreatorTaskMiddleware')->only(["show"]);
    }

    /**
     * Display a listing of the Tasks.
     */
    public function index()
    {
        return Task::paginate(15);
    }

    public function getMyTasks(){
        $tasks=Task::where('assigned_user_id', Auth::id())->orWhere('creator_user_id', Auth::id())->paginate(15);
        return view('mytasks', compact('tasks'));


    }

    /**
     *  Assign Task  to specific users
     *  The  user who assign  must be the  creator of task or admin .
     */

    public function AssignTask(Request $request, $task)
    {
        
        $task = Task::findOrFail($task);
        $user =User::findOrFail($request->assignedUserId);
        $task->update(['assigned_user_id' => $request->assignedUserId]);
        Mail::to( $task->assignedUser->email)->send(new NotificationEmail("Task assigned to you "," The task {$task->title}  has assigned to  you task  by \" {$task->creatorUser->name}\" "));

        return response()->json([
            'success' => true,
            'message' => ' Task Assigned successfully',
        ], 200);
    }
    /**
     * This methode to Mark Tasks As Completed
     * The  user who Mark Tasks As Completed  must be the  ASSIGNED USER  of task or admin .
     */
    public function MarkTasksAsCompleted(Request $request, $task)
    {
        $task = Task::findOrFail($task);
        
        $task->update(['status' => self::completedStatus,]);
        Mail::to( $task->creatorUser->email)->send(new NotificationEmail("Completed Task","{$task->assignedUser->name}  has marked your task \"  $task->title \" as completed"));

        return response()->json([
            'success' => true,
            'message' => 'The task marked as completed successfully',
        ], 200);
    }


    /**
     *  Filter  tasks by status for spesfic user tasks
     */

    public function filterTasks($filter)
    {

        $filter = ['filter' => $filter];
        Validator::make($filter, [
            'filter' => 'in:pending,completed'
        ]);

        $tasks = Task::where('status', $filter);
        $tasks = $tasks ->where(function ($query) {
                    $query->where('assigned_user_id', Auth::id())
                    ->orWhere('creator_user_id', Auth::id());
        });
        return $tasks->paginate(15);
    }

    /**
     * Filter tasks for all users
     */

    public function filterAllTasks($filter)
    {

        $filter = ['filter' => $filter];
        Validator::make($filter, [
            'filter' => 'in:pending,completed'
        ]);

        $tasks = Task::where('status', $filter);
        return $tasks->paginate(15);
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
            'creator_user_id' => Auth::id(),
            'status' => self::pendingStatus,
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
        $task = Task::findOrFail($taskId);
        $task->update($request->all());
        return response()->json('The task has been updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($taskId)
    {
        Task::findOrFail($taskId)->delete();
        return response()->json('The task has been deleted successfully', 204);
    }
}

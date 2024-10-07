<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminTaskCreateRequest;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ManageTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::query();
        if ($request->has('search') && $request->search) {
            $tasks->where('title', 'like', '%' . $request->search . '%')->orWhere('task_number', 'like', '%' . $request->search . '%');
        }
        if ($request->has('status') && $request->status) {
            $tasks->where('status', $request->status);
        }
        if ($request->has('due_date') && $request->due_date) {
            $tasks->where('due_date', $request->due_date);
        }
        $tasks = $tasks->with(['user'])->orderBy('created_at', 'desc')->paginate(25);
      
        return view('admin.tasks.index', compact('tasks'));
    }
    public function getLiveTasks(Request $request)
    {
        $tasks = Task::with(['user'])->orderBy('created_at', 'desc')->paginate(25); 
        return response()->json([
            'tasks' => $tasks,
            'pagination' => (string) $tasks->appends($request->query())->links(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('user_role','user')->get();
        return view('admin.tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminTaskCreateRequest $request)
    {
        try {
            $task_number = rand(111111, 999999);
            $image = fileUpload($request, 'image', '/images/');
           
            Task::create([
                'task_number' => $task_number,
                'assigned_to' => $request->assigned_to,
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'due_date' => $request->due_date,
                'image' => $image,
            ]);
            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with(['user'])->findOrFail($id);

        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $users = User::where('user_role','user')->get();
        return view('admin.tasks.edit', compact('task','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $image = updateFileUpload($request, 'image', '/images/', $task, 'image');
            $task->title = $request->title;
            $task->assigned_to = $request->assigned_to;
            $task->description = $request->description;
            $task->due_date = $request->due_date;
            $task->status = $request->status;
            $task->image = $image;
            $task->save();
            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function updateStatus(Request $request, $id)
    {

        try {
            $task = Task::findOrFail($id);
            if ($request->status === 'Completed') {
                $task->status = 'Completed';
                $task->completed_at = now();
            } else {
                $task->status = $request->status;
                $task->completed_at = null; 
            }
            $task->save();
            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }
}

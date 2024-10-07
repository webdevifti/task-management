<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index()
    {
        $total_tasks = Task::count();
        $total_completed_task = Task::where('status', 'Completed')->count();
        $total_in_progress_task = Task::where('status', 'In Progress')->count();
        $total_pending_task = Task::where('status', 'Pending')->count();
        $total_users = User::where('user_role', 'user')->count();
        $topUserWithCompletedTasks = Task::select('users.name', 'users.id', DB::raw('COUNT(tasks.id) as completed_tasks_count'))
            ->join('users', 'tasks.assigned_to', '=', 'users.id')
            ->where('tasks.status', 'Completed')
            ->groupBy('users.id', 'users.name')
            ->orderBy('completed_tasks_count', 'DESC')
            ->first();


        $users = User::with(['tasks' => function ($query) {
            $query->where('status', 'Completed')->whereNotNull('completed_at');
        }])->get();

        $userStats = $users->map(function ($user) {
            $completedTasks = $user->tasks;

            if ($completedTasks->count() > 0) {
                $totalTime = $completedTasks->reduce(function ($carry, $task) {
                    $created_at = Carbon::parse($task->created_at);
                    $completed_at = Carbon::parse($task->completed_at);
                    $taskTime = $created_at->diffInMinutes($completed_at);
                    return $carry + $taskTime;
                }, 0);

                $averageTime = $totalTime / $completedTasks->count();

                return [
                    'user_id' => $user->id,
                    'user' => $user->name,
                    'average_time' => $averageTime,
                    'tasks_completed' => $completedTasks->count(),
                ];
            }

            return [
                'user_id' => $user->id,
                'user' => $user->name,
                'average_time' => null,
                'tasks_completed' => 0,
            ];
        });
   

        return view('admin.index', compact('total_tasks', 'total_completed_task', 'total_in_progress_task', 'total_pending_task', 'total_users', 'topUserWithCompletedTasks','userStats'));
    }
}

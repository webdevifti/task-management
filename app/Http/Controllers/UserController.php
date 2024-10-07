<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $total_task = Task::where('assigned_to', Auth::id())->count();
        $total_completed_tickets = Task::where('assigned_to', Auth::id())->where('status','Completed')->count();
        $total_pending_tickets = Task::where('assigned_to', Auth::id())->where('status','Pending')->count();
        $total_progress_tickets = Task::where('assigned_to', Auth::id())->where('status','In Progress')->count();
        return view('user.index',compact('total_task','total_completed_tickets','total_pending_tickets','total_progress_tickets'));
    }
    public function profile(){
        $user = Auth::user();
        return view('profile', compact('user'));
    }
    public function profileUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string'
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return back()->with('success', 'Profile has been updated!');
    }

    // users pasword update
    public function passwordUpdate(Request $request, $id)
    {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        try {
            $user = User::findOrFail($id);
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'The current password does not match our records.');
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return back()->with('success', 'Password updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Something wrong!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $club_id = $user->club_id;
        $id = $user->id;
        $tasks = Task::where('task.admin_id', $id)
            ->where('task.club_id', $club_id)
            ->join('task_description','task.status','task_description.id')
            ->leftJoin('users', 'task.admin_id', 'users.id')
            ->select('task.descript_admin', 'task.create_dt', 'task.end_dt','users.name','users.name','task_description.description', 'task_description.color')
            ->get();
        //dd($tasks);
        return view('task.index', compact('club_id', 'tasks'));
    }
}

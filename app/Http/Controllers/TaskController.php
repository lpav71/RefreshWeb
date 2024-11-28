<?php

namespace App\Http\Controllers;

use App\Http\Common\TaskCommon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user     = Auth::user();
        $club_id  = $user->club_id;
        $admin_id = $user->id;
        $tasks    = TaskCommon::getAll($club_id, $admin_id);
        return view('task.index', compact('club_id', 'admin_id', 'tasks'));
    }
}

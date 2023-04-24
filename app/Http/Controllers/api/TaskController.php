<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    public function tasks(Request $request)
    {
        $tasks = Task::where('club_id', $request->club_id)->where( 'admin_id', $request->admin_id)->get();
        for ($i = 0; $i <= count($tasks)-1; $i++) {
            $tasks[$i]->create_dt = Carbon::parse($tasks[$i]->create_dt)->format('d.m.Y H:i');
        }
        return $tasks;
    }
}

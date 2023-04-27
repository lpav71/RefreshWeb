<?php

namespace App\Http\Controllers\api;

use App\Http\Common\TaskCommon;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskDescription;
use App\Models\User;
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
    public function users(Request $request)
    {
        $users = User::where('club_id', $request->club_id)->get();
        return $users;
    }
    public function saveAddModal(Request $request)
    {
        $descript_admin = $request->descript_admin;
        $date_public = $request->date_public;
        $days = $request->days;
        $hours = $request->hours;
        $executor = $request->executor;
        $club_id = $request->club_id;
        $admin_id = $request->admin_id;

        $end_dt = Carbon::parse($date_public)->addDay($days)->addHours($hours);
        $task = new Task();
        $task->descript_admin = $descript_admin;
        $task->create_dt = $date_public;
        $task->end_dt = $end_dt;
        $task->employ = $executor;
        $task->admin_id = $admin_id;
        $task->club_id = $club_id;
        $task->status = 1;
        $task->save();
        return $task;
    }
    public function getNewStatus(Request $request)
    {
        $status = TaskDescription::find($request->id);
        return $status;
    }
    public function saveNewStatus(Request $request)
    {
        $id = $request->id;
        $idDesk = $request->id_desk;
        $task = Task::find($id);
        $task->status = $idDesk;
        $task->save();
        return $task;
    }
    public function allTasks(Request $request)
    {
        $tasks = TaskCommon::getAll($request->club_id, $request->admin_id);
        return $tasks;
    }
}

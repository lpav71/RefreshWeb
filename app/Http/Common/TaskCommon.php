<?php

namespace App\Http\Common;

use App\Models\Task;

class TaskCommon
{
    public static function getAll($club_id, $admin_id)
    {
        $tasks = Task::where('task.admin_id', $admin_id)
            ->where('task.club_id', $club_id)
            ->join('task_description','task.status','task_description.id')
            ->leftJoin('users', 'task.admin_id', 'users.id')
            ->select('task.descript_admin', 'task.id', 'task.create_dt', 'task.end_dt','users.name','users.name','task_description.description', 'task_description.color', 'task_description.id as id_desk')
            ->orderBy('id')
            ->get();
        return $tasks;
    }
}

<?php

namespace App\Policies;

use App\Entities\Eloquents\Task as TaskEloquent;
use App\Entities\Eloquents\User as UserEloquent;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param UserEloquent $user
     * @param TaskEloquent $task
     * @return bool
     */
    public function destroy(UserEloquent $user, TaskEloquent $task)
    {
        return $user->id === $task->user_id;
    }
}

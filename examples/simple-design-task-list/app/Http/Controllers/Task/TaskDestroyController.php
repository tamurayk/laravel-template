<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Eloquents\Task;
use App\Models\Entities\TaskInterface;
use Illuminate\Http\RedirectResponse;

class TaskDestroyController extends Controller
{
    /** @var Task */
    private $task;

    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * @param int $taskId
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(int $taskId): RedirectResponse
    {
        $task = $this->task->newQuery()->find($taskId);

        // note: 1st arg of authorize() is Policy name that is related Task Model.
        $this->authorize('destroy', $task);

        $task->delete(); //TODO: Use UseCase

        return redirect('/tasks');
    }
}

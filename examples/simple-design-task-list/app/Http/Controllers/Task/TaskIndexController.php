<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Eloquents\Task;
use App\Models\Entities\TaskInterface;
use Illuminate\Contracts\Auth\Guard;

class TaskIndexController extends Controller
{
    /** @var Task */
    private $task;

    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * @param Guard $guard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Guard $guard)
    {
        $userId = $guard->user()->id;

        // TODO: use UseCase
        $query = $this->task->newQuery();
        $tasks = $query->where('user_id', $userId)->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }
}

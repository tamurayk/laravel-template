<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contracts\Task\TaskStoreRequest as TaskStoreRequestInterface;
use App\Models\Eloquents\Task;
use App\Models\Entities\TaskInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\Guard;

class TaskController extends Controller
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
    public function index(Guard $guard)
    {
        $userId = $guard->user()->id;

        // TODO: use UseCase
        $query = $this->task->newQuery();
        $tasks = $query->where('user_id', $userId)->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @param TaskStoreRequestInterface $request
     * @return RedirectResponse
     */
    public function store(TaskStoreRequestInterface $request): RedirectResponse
    {
        // TODO: Use UseCase
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('task.index');
    }

    /**
     * @param int $taskId
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $taskId): RedirectResponse
    {
        $task = $this->task->newQuery()->find($taskId);

        // note: 1st arg of authorize() is Policy name that is related Task Model.
        $this->authorize('destroy', $task);

        $task->delete(); //TODO: Use UseCase

        return redirect('/tasks');
    }
}

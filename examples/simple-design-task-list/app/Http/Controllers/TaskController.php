<?php

namespace App\Http\Controllers;

use App\Entities\Contracts\Task as TaskInterface;
use App\Entities\Eloquents\Task as TaskEloquent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class TaskController extends Controller
{
    /**
     * @var TaskEloquent
     */
    private $taskEloquent;

    public function __construct(TaskInterface $task)
    {
        $this->taskEloquent = $task;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) //TODO: Use Guard
    {
        $userId = 1;

        // TODO: use UseCase
        $query = $this->taskEloquent->newQuery();
        $tasks = $query->where('user_id', $userId)->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // TODO: Use formRequest
        $this->validate($request, [
            'name' => 'required|max:10',
        ]);

        // TODO: Use UseCase
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('task.index');
    }

    /**
     * @param Request $request
     * @param TaskEloquent $task
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, TaskEloquent $task): RedirectResponse
    {
        // note: 1st arg of authorize() is Policy name that is related Task Model.
        $this->authorize('destroy', $task);

        $task->delete(); //TODO: Use UseCase

        return redirect('/tasks');
    }
}

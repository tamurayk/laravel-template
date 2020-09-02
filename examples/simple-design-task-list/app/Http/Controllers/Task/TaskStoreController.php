<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\Contracts\TaskStoreRequestInterface;
use App\Models\Eloquents\Task;
use App\Models\Entities\TaskInterface;
use Illuminate\Http\RedirectResponse;

class TaskStoreController extends Controller
{
    /** @var Task */
    private $task;

    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * @param TaskStoreRequestInterface $request
     * @return RedirectResponse
     */
    public function __invoke(TaskStoreRequestInterface $request): RedirectResponse
    {
        // TODO: Use UseCase
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('task.index');
    }
}

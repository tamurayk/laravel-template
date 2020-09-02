<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Task\Contracts\TaskDestroyUseCaseInterface;
use App\Models\Eloquents\Task;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class TaskDestroyController extends Controller
{
    /**
     * @param Guard $guard
     * @param Task $task
     * @param TaskDestroyUseCaseInterface $useCase
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(
        Guard $guard,
        Task $task, // TaskEloquentModel Passed by Implicit Binding.
        TaskDestroyUseCaseInterface $useCase
    ): RedirectResponse {
        // note: 1st arg of authorize() is Policy name that is related Task Model.
        $this->authorize('destroy', $task);

        $useCase($guard->user()->id, $task->id);

        return redirect('/tasks');
    }
}

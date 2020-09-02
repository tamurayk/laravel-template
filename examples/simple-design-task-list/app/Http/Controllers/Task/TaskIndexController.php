<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Task\Contracts\TaskIndexUseCaseInterface;
use Illuminate\Contracts\Auth\Guard;

class TaskIndexController extends Controller
{
    /**
     * @param Guard $guard
     * @param TaskIndexUseCaseInterface $useCase
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Guard $guard, TaskIndexUseCaseInterface $useCase)
    {
        $userId = $guard->user()->id;

        $tasks = $useCase($userId);

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Task\Interfaces\TaskIndexInterface;
use Illuminate\Contracts\Auth\Guard;

class TaskIndexController extends Controller
{
    /**
     * @param Guard $guard
     * @param TaskIndexInterface $useCase
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Guard $guard, TaskIndexInterface $useCase)
    {
        $userId = $guard->user()->id;

        $tasks = $useCase($userId);

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Task\Interfaces\TaskIndexInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class TaskIndexController extends Controller
{
    /**
     * @param Guard $guard
     * @param TaskIndexInterface $useCase
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Guard $guard, TaskIndexInterface $useCase, Request $request)
    {
        $userId = $guard->user()->id;

        $tasks = $useCase(
            $userId,
            $request->query('perPage', null) ? (int) $request->query('perPage') : null,
            $request->query('orderColumn', null),
            $request->query('orderDirection', null)
        );

        return view('tasks.index', [
            'tasks' => $tasks->appends($request->query()),
        ]);
    }
}

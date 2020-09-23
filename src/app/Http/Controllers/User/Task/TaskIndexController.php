<?php
declare(strict_types=1);

namespace App\Http\Controllers\User\Task;

use App\Http\Controllers\User\AppController;
use App\Http\UseCases\User\Task\Interfaces\TaskIndexInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class TaskIndexController extends AppController
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

        $paginator = $useCase(
            $userId,
            $request->query('perPage', null) ? (int) $request->query('perPage') : null,
            $request->query('column', null),
            $request->query('direction', null)
        );

        return view('user.task.index', [
            'paginator' => $paginator->appends($request->query()),
        ]);
    }
}

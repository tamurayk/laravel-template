<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\Contracts\TaskStoreRequestInterface;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\UseCases\Task\Contracts\TaskStoreUseCaseInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class TaskStoreController extends Controller
{
    /**
     * @param Guard $guard
     * @param TaskStoreRequestInterface $request
     * @param TaskStoreUseCaseInterface $useCase
     * @return RedirectResponse
     */
    public function __invoke(
        Guard $guard,
        TaskStoreRequestInterface $request,
        TaskStoreUseCaseInterface $useCase
    ): RedirectResponse {
        $userId = $guard->user()->id;

        /** @var TaskStoreRequest $request */
        $validated = $request->validated();

        $useCase($userId, $validated);

        return redirect()->route('task.index');
    }
}

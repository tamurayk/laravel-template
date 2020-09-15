<?php
declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Http\Controllers\AppController;
use App\Http\Requests\Task\Interfaces\TaskStoreRequestInterface;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\UseCases\Task\Interfaces\TaskStoreInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class TaskStoreController extends AppController
{
    /**
     * @param Guard $guard
     * @param TaskStoreRequestInterface $request
     * @param TaskStoreInterface $useCase
     * @return RedirectResponse
     */
    public function __invoke(
        Guard $guard,
        TaskStoreRequestInterface $request,
        TaskStoreInterface $useCase
    ): RedirectResponse {
        $userId = $guard->user()->id;

        /** @var TaskStoreRequest $request */
        $validated = $request->validated();

        $useCase($userId, $validated);

        return redirect()->route('task.index');
    }
}

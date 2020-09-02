<?php

namespace App\Http\UseCases\Task\Contracts;

use App\Models\Entities\TaskInterface;

interface TaskDestroyUseCaseInterface
{
    public function __construct(TaskInterface $task);

    public function __invoke(int $userId, int $taskId);
}

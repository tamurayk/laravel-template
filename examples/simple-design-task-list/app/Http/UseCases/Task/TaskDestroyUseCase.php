<?php

namespace App\Http\UseCases\Task;

use App\Http\UseCases\Task\Contracts\TaskDestroyUseCaseInterface;
use App\Models\Eloquents\Task;
use App\Models\Entities\TaskInterface;

class TaskDestroyUseCase implements TaskDestroyUseCaseInterface
{
    /** @var Task */
    private $taskEloquent;

    public function __construct(TaskInterface $task)
    {
        $this->taskEloquent = $task;
    }

    /**
     * @param int $userId
     * @param int $taskId
     * @return mixed
     */
    public function __invoke(int $userId, int $taskId)
    {
        return $this->taskEloquent->newQuery()
            ->where('id', $taskId)
            ->where('user_id', $userId)
            ->delete();
    }
}

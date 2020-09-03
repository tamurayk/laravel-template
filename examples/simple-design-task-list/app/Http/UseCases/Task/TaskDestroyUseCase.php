<?php
declare(strict_types=1);

namespace App\Http\UseCases\Task;

use App\Http\UseCase\Task\Exceptions\TaskDestroyFailureException;
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
     * @return bool
     * @throws TaskDestroyFailureException
     */
    public function __invoke(int $userId, int $taskId): bool
    {
        $result = $this->taskEloquent->newQuery()
            ->where('id', $taskId)
            ->where('user_id', $userId)
            ->delete();

        if (!$result) {
            throw new TaskDestroyFailureException('Failed to delete task.', 403);
        }

        return true;
    }
}

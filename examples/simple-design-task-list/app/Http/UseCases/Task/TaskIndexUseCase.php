<?php

namespace App\Http\UseCases\Task;

use App\Http\UseCases\Task\Contracts\TaskIndexUseCaseInterface;
use App\Models\Eloquents\Task;
use App\Models\Entities\TaskInterface;

class TaskIndexUseCase implements TaskIndexUseCaseInterface
{
    /** @var Task */
    private $task;

    /**
     * TaskIndexController constructor.
     * @param TaskInterface $task
     */
    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function __invoke(int $userId)
    {
        $query = $this->task->newQuery();
        $tasks = $query->where('user_id', $userId)->get();

        return $tasks;
    }
}

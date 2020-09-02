<?php

namespace App\Http\UseCases\Task;

use App\Http\UseCases\Task\Contracts\TaskStoreUseCaseInterface;
use App\Models\Eloquents\Task;
use App\Models\Entities\TaskInterface;

class TaskStoreUseCase implements TaskStoreUseCaseInterface
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
     * @param int $useId
     * @param array $data
     * @return bool
     */
    public function __invoke(int $useId, array $data): bool
    {
        $fill = array_merge($data, [
            'user_id' => $useId,
        ]);

        $task = $this->task->newInstance($fill);
        return $task->save();
    }
}

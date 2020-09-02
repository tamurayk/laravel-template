<?php

namespace App\Http\UseCases\Task\Contracts;

use App\Models\Entities\TaskInterface;

interface TaskIndexUseCaseInterface
{
    public function __construct(TaskInterface $task);

    /**
     * @param int $userId
     */
    public function __invoke(int $userId);
}

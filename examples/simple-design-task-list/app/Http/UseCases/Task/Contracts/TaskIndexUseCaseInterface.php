<?php
declare(strict_types=1);

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

<?php
declare(strict_types=1);

namespace App\Http\UseCases\Task\Interfaces;

use App\Models\Interfaces\TaskInterface;

interface TaskIndexInterface
{
    public function __construct(TaskInterface $task);

    /**
     * @param int $userId
     */
    public function __invoke(int $userId);
}

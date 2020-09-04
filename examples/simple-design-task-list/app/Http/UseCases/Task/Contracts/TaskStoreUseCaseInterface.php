<?php
declare(strict_types=1);

namespace App\Http\UseCases\Task\Contracts;

use App\Models\Entities\TaskInterface;

interface TaskStoreUseCaseInterface
{
    public function __construct(TaskInterface $task);

    public function __invoke(int $userId, array $data): bool ;
}

<?php
declare(strict_types=1);

namespace App\Http\UseCases\Task\Interfaces;

use App\Models\Constants\TaskConstants;
use App\Models\Interfaces\TaskInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskIndexInterface
{
    public function __construct(TaskInterface $task);

    /**
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function __invoke(
        int $userId,
        int $perPage = TaskConstants::PER_PAGE
    ): LengthAwarePaginator;
}

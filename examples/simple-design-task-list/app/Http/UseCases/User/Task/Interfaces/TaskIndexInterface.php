<?php
declare(strict_types=1);

namespace App\Http\UseCases\User\Task\Interfaces;

use App\Models\Interfaces\TaskInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskIndexInterface
{
    public function __construct(TaskInterface $task);

    /**
     * @param int $userId
     * @param int|null $perPage
     * @param string|null $orderColumn
     * @param string|null $orderDirection
     * @return LengthAwarePaginator
     */
    public function __invoke(
        int $userId,
        ?int $perPage,
        ?string $orderColumn = null,
        ?string $orderDirection = null
    ): LengthAwarePaginator;
}

<?php
declare(strict_types=1);

namespace App\Http\UseCases\User\Task\Interfaces;

use App\Models\Interfaces\TaskInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface TaskIndexInterface
{
    public function __construct(TaskInterface $task);

    /**
     * @return LengthAwarePaginator<Model>
     */
    public function __invoke(
        int $userId,
        array $searchParam = [],
        array $paginatorParam = []
    ): LengthAwarePaginator;
}

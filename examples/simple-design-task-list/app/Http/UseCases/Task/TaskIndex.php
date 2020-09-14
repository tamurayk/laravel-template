<?php
declare(strict_types=1);

namespace App\Http\UseCases\Task;

use App\Http\UseCases\Task\Interfaces\TaskIndexInterface;
use App\Models\Constants\TaskConstants;
use App\Models\Eloquents\Task;
use App\Models\Interfaces\TaskInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskIndex implements TaskIndexInterface
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
     * @param int|null $perPage
     * @param string|null $orderColumn
     * @param string|null $orderDirection
     * @return LengthAwarePaginator
     */
    public function __invoke(
        int $userId,
        ?int $perPage,
        ?string $orderColumn,
        ?string $orderDirection
    ): LengthAwarePaginator {
        $perPage = $perPage ?? TaskConstants::PER_PAGE;
        $orderColumn = $orderColumn ?? 'created_at';
        $orderDirection = $orderDirection ?? 'desc';

        $query = $this->task->newQuery()
            ->where('user_id', $userId)
            ->orderBy($orderColumn, $orderDirection);

        // paginate() メソッド実行時に、HTTP Request の page クエリ文字列から対象ページを自動取得し、SQL に limit と offset が付与される
        $paginator = $query->paginate($perPage);

        return $paginator;
    }
}

<?php

use Illuminate\Support\Arr;

if (!function_exists('sort_query_str')) {
    /**
     * ソート用のクエリ文字列を生成して返す
     *
     * @param array $currentQueries
     * @param string $orderColumn
     * @param string|null $orderDirection must be "asc" or "desc"
     * @return string
     * @param string $columnKey
     * @param string $directionKey
     */
    function sort_query_str(
        array $currentQueries,
        string $orderColumn,
        ?string $orderDirection = null,
        string $columnKey = 'column',
        string $directionKey = 'direction'
    ):string {
        $newQueries = $currentQueries;
        $currentColumn = Arr::get($currentQueries, $columnKey);
        $currentDirection = Arr::get($currentQueries, $directionKey);

        // directionが指定されてない場合
        if (is_null($orderDirection)) {
            // 現在のdirectionを反転
            if ($currentDirection
                && $currentColumn === $orderColumn
                && $currentDirection === 'asc'
            ) {
                $orderDirection = 'desc';
            } else {
                $orderDirection = 'asc';
            }
        }

        $newQueries[$columnKey] = $orderColumn;
        $newQueries[$directionKey] = $orderDirection;

        $queryString = '';
        foreach ($newQueries as $k => $v) {
            $queryString .= sprintf(
                '%s%s=%s',
                strpos($queryString, '?') === false ? '?' : '&',
                $k,
                $v
            );
        }

        return $queryString;
    }
}

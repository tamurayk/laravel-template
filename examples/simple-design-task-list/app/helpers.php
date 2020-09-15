<?php

use Illuminate\Support\Arr;

if (!function_exists('sort_url')) {
    /**
     * ソート用のURLを返す
     *
     * @param string $currentUri
     * @param string $orderColumn
     * @param string|null $orderDirection must be "asc" or "desc"
     * @param string $columnKey
     * @param string $directionKey
     * @return string
     */
    function sort_url(
        string $currentUri,
        string $orderColumn,
        ?string $orderDirection = null,
        string $columnKey = 'column',
        string $directionKey = 'direction'
    ):string {
        $parsedUri = parse_url($currentUri);
        parse_str(Arr::get($parsedUri, 'query'), $queries);

        $queries[$columnKey] = $orderColumn;
        if (!is_null($orderDirection)) {
            $queries[$directionKey] = $orderDirection;

        }
        $query = '?' . http_build_query($queries);

        $scheme = isset($parsedUri['scheme']) ? $parsedUri['scheme'] . '://' : '';
        $host = isset($parsedUri['host']) ? $parsedUri['host'] : '';
        $port = isset($parsedUri['port']) ? ':' . $parsedUri['port'] : '';
        $user = isset($parsedUri['user']) ? $parsedUri['user'] : '';
        $pass = isset($parsedUri['pass']) ? ':' . $parsedUri['pass']  : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsedUri['path']) ? $parsedUri['path'] : '';
        $fragment = isset($parsedUri['fragment']) ? '#' . $parsedUri['fragment'] : '';

        return sprintf('%s%s%s%s%s%s%s%s', $scheme, $user, $pass, $host, $port, $path, $query, $fragment);
    }
}

if (!function_exists('sort_direction')) {
    /**
     * 現在のソートの状態から、ソートボタン押下後の direction を算出
     *
     * @param string $orderColumn
     * @param string|null $currentColumn
     * @param string|null $currentDirection
     * @return string
     */
    function sort_direction(
        string $orderColumn,
        ?string $currentColumn = null,
        ?string $currentDirection = null
    ):string {
        $orderDirection = 'asc';

        if ($currentDirection
            && $currentColumn === $orderColumn
            && $currentDirection === 'asc'
        ) {
            $orderDirection = 'desc';
        }

        return $orderDirection;
    }
}

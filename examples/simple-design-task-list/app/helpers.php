<?php

use Illuminate\Pagination\LengthAwarePaginator;

if (!function_exists('sort_url')) {
    /**
     * ソート用のURLを生成
     *
     * @param LengthAwarePaginator $paginator
     * @param array $currentQueries
     * @param string $orderColumn
     * @param string|null $orderDirection
     * @return string
     */
    function sort_url(
        LengthAwarePaginator $paginator,
        array $currentQueries,
        string $orderColumn,
        ?string $orderDirection = null
    ) {
        // ソートURL生成の際の appends の影響が、ソートURL生成後に出現する $paginator->links() に出ないように clone している
        $paginator = clone $paginator;

        // direction(=asc/desc)が指定されてない場合
        if (is_null($orderDirection)) {
            // 現在のリクエストで指定されてるdirectionを反転
            if (array_key_exists('orderDirection', $currentQueries)
                && $orderColumn === Arr::get($currentQueries, 'orderColumn')
                && Arr::get($currentQueries, 'orderDirection') === 'asc'
            ) {
                $orderDirection = 'desc';
            } else {
                $orderDirection = 'asc';
            }
        }

        $paginator->appends(['orderColumn' => $orderColumn, 'orderDirection' => $orderDirection,]);
        $url = $paginator->url($paginator->currentPage());

        return $url;
    }
}

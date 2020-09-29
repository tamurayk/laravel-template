<?php
declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Route;

trait RoutingTestTrait
{
    private $router;
    private $findRoute;

    public function initAssertRouting() {
        // RouteCollection 取得
        // note: \Tests\TestCase の CreatesApplication トレイトで Application が生成される際に、
        //       routes 以下の設定ファイルで定義された Route が Route ファサードにセットされる
        $routeCollection = Route::getRoutes();

        // Router生成
        $this->router = new \Illuminate\Routing\Router(new Dispatcher());

        // Router に RouteCollection をセット
        $this->router->setRoutes($routeCollection);

        // Routerインスタンス の protected メソッドにアクセスする為に Reflection
        $reflectionRouter = new \ReflectionClass(get_class($this->router));
        $this->findRoute = $reflectionRouter->getMethod('findRoute');
        $this->findRoute->setAccessible(true);
    }

    /**
     * 任意の Request を Router に渡し、期待値通りの Route が dispatch される事をテスト
     *
     * @param string $url
     * @param string $method
     * @param array $expected
     */
    public function assertRouting(string  $url, string $method, array $expected)
    {
        // リクエスト生成
        $request = \Illuminate\Http\Request::create($url, strtoupper($method));

        // Router に Request を渡し、dispatch された Route を取得
        /** @var \Illuminate\Routing\Route $route */
        $route = $this->findRoute->invokeArgs($this->router, [$request]);

        // assert
        $this->assertEquals(
            $expected['actionName'],
            $route->getActionName(),
            'リクエストに対応するコントローラが期待値通りである事'
        );
        $this->assertEquals(
            $expected['routeName'],
            $route->getName(),
            'リクエストに対応するルート名が期待値通りである事'
        );

    }

    public function AppliedMiddlewareTestDataProvider()
    {
        return [
            /**
             * Example
             *
             * [
             *     // テスト対象: URI (Route::get() 等の第一引数で設定した $uri)
             *     'admin/users',
             *
             *     // テスト対象: メソッド
             *     'GET',
             *
             *     // 期待値: Route に適用される Middleware
             *     [
             *         'admin',
             *         'auth:admin'
             *     ],
             * ],
             */
            [
                //
            ],
        ];
    }

    /**
     * @dataProvider AppliedMiddlewareTestDataProvider
     * @param string $uri
     * @param string $method
     * @param array $expectedMiddleware
     */
    public function testAppliedMiddleware(
        string $uri,
        string $method,
        array $expectedMiddleware
    ) {
        // RouteCollection 取得
        $routeCollection = Route::getRoutes();

        // RouteCollection から テスト対象 Route を取得
        $route = collect($routeCollection)
            ->where('uri', $uri)
            ->filter(function ($route) use ($method)  {
                return in_array(strtoupper($method), $route->methods);
            })
            ->first();

        // テスト対象 Route に適用される Middleware を取得
        $appliedMiddleware = $route->action['middleware'];

        // assert
        $this->assertCount(count($expectedMiddleware), $appliedMiddleware);
        foreach ($expectedMiddleware as $middleware) {
            $this->assertTrue(in_array($middleware, $appliedMiddleware));
        }
    }
}

<?php
declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Route;

trait RoutingTestTrait
{
    public function RoutingDispatchTestDataProvider()
    {
        return [
            /**
             * Example
             *
             * [
             *     'http://localhost:8000/home/', //テスト対象: URL
             *     'GET', //テスト対象: メソッド
             *     HomeController::class . '@index', //期待値: コントローラ名@アクション名 or Closure
             *     'home' //期待値: ルート名
             * ],
             */
            [
                //
            ],
        ];
    }

    /**
     * @dataProvider RoutingDispatchTestDataProvider
     * @param string $url
     * @param string $method
     * @param string $expectedActionName
     * @param string $expectedRouteName
     * @throws \ReflectionException
     */
    public function testDispatch(
        string $url,
        string $method,
        string $expectedActionName,
        string $expectedRouteName
    ) {
        /**
         * テスト内容
         *   任意の Request を Router に渡して dispatch された Route が期待値通りである事を確認
         */

        // Router生成
        $router = new \Illuminate\Routing\Router(new Dispatcher());
        $this->assertEquals(0, $router->getRoutes()->count(), 'Router に RouteCollection がセットされていない事を確認');

        // RouteCollection 取得
        // note: \Tests\TestCase の CreatesApplication トレイトで Application が生成される際に、
        //       routes 以下の設定ファイルで定義された Route が Route ファサードにセットされる
        $routeCollection = Route::getRoutes();

        // Router に RouteCollection をセット
        $router->setRoutes($routeCollection);
        $this->assertGreaterThanOrEqual(1, $router->getRoutes()->count(), 'Router に RouteCollection がセットされた事を確認');

        // Routerインスタンス の protected メソッドにアクセスする為に Reflection
        $reflectionRouter = new \ReflectionClass(get_class($router));
        $findRoute = $reflectionRouter->getMethod('findRoute');
        $findRoute->setAccessible(true);

        // リクエスト生成
        $request = \Illuminate\Http\Request::create($url, strtoupper($method));

        // Router に Request を渡し、dispatch された Route を取得
        /** @var \Illuminate\Routing\Route $route */
        $route = $findRoute->invokeArgs($router, [$request]);

        // assert
        $this->assertEquals(
            $expectedActionName,
            $route->getActionName(),
            'リクエストに対応するコントローラが期待値通りである事'
        );
        $this->assertEquals(
            $expectedRouteName,
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

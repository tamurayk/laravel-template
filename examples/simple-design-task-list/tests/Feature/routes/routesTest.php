<?php

namespace Tests\Feature\routes;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Task\TaskDestroyController;
use App\Http\Controllers\Task\TaskIndexController;
use App\Http\Controllers\Task\TaskStoreController;
use Illuminate\Events\Dispatcher;
use Tests\BaseTestCase;
use Illuminate\Support\Facades\Route;

final class routesTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function DispatchDataProvider()
    {
        // TODO: config() から取得する
        $baseUrl = 'http://localhost:8000';

        return [
            /**
             * Example
             *
             * [
             *     'GET', //テスト対象: メソッド
             *     'http://localhost:8000/home/', //テスト対象: URL
             *     HomeController::class . '@index', //期待値: コントローラ名@アクション名 or Closure
             *     'home' //期待値: ルート名
             * ],
             */
            [
                'GET',
                $baseUrl. '/',
                'Closure',
                null,
            ],
            [
                'GET',
                $baseUrl. '/home',
                HomeController::class . '@index',
                'home',
            ],
            [
                'GET',
                $baseUrl. '/tasks',
                TaskIndexController::class,
                'task.index',
            ],
            [
                'POST',
                $baseUrl. '/task',
                TaskStoreController::class,
                'task.store',
            ],
            [
                'DELETE',
                $baseUrl. '/task/1',
                TaskDestroyController::class,
                'task.destroy',
            ],
            [
                'GET',
                $baseUrl. '/login/github',
                LoginController::class . '@redirectToProvider',
                'oauth.login',
            ],
            [
                'GET',
                $baseUrl. '/login/github/callback',
                LoginController::class . '@handleProviderCallback',
                'oauth.callback',
            ],
        ];
    }

    /**
     * @dataProvider DispatchDataProvider
     * @param $method
     * @param $url
     * @param $expectedActionName
     * @param $expectedRouteName
     * @throws \ReflectionException
     */
    public function testDispatch(
        $method,
        $url,
        $expectedActionName,
        $expectedRouteName
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
        $this->assertGreaterThan(1, $router->getRoutes()->count(), 'Router に RouteCollection がセットされた事を確認');

        // Routerインスタンス の protected メソッドにアクセスする為に Reflection
        $reflectionRouter = new \ReflectionClass(get_class($router));
        $findRoute = $reflectionRouter->getMethod('findRoute');
        $findRoute->setAccessible(true);

        // リクエスト生成
        $request = \Illuminate\Http\Request::create($url, $method);

        // Router に Request を渡し、dispatch された Route を取得
        /** @var \Illuminate\Routing\Route $route */
        $route = $findRoute->invokeArgs($router, [$request]);
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
}

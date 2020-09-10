<?php

namespace Tests\Feature\routes;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Task\TaskDestroyController;
use App\Http\Controllers\Task\TaskIndexController;
use App\Http\Controllers\Task\TaskStoreController;
use Illuminate\Events\Dispatcher;
use Tests\BaseTestCase;
use Illuminate\Support\Facades\Route;

final class webTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function RouteActionNameDataProvider()
    {
        return [
            /**
             * Example
             *
             * [
             *     'get', //method
             *     '/tasks', //テスト対象の url
             *     TaskIndexController::class, //期待されるアクション名
             *     'task.index' //期待されるルート名
             * ],
             */
            [
                'get',
                '/home',
                HomeController::class . '@index',
                'home'
            ],
            [
                'get',
                '/tasks',
                TaskIndexController::class,
                'task.index'
            ],
            [
                'post',
                '/task',
                TaskStoreController::class,
                'task.store'
            ],
            [
                'delete',
                '/task/1',
                TaskDestroyController::class,
                'task.destroy'
            ],
        ];
    }

    /**
     * @dataProvider RouteActionNameDataProvider
     * @param $method
     * @param $url
     * @param $expectedActionName
     * @param $expectedRouteName
     */
    public function testRouteActionName(
        $method,
        $url,
        $expectedActionName,
        $expectedRouteName
    )
    {
        // 特定のテストでのみミドルウェアを無効化
        $this->withoutMiddleware();

        switch ($method) {
            case 'post':
                $this->post($url);
                break;
            case 'get':
                $this->get($url);
                break;
            case 'delete':
                $this->delete($url);
                break;
            default:
                $this->get($url);
        }

        $this->assertEquals($expectedRouteName, Route::currentRouteName());
        $this->assertEquals($expectedActionName, Route::currentRouteAction());
    }

    public function testDispatch()
    {
        /**
         * テスト内容
         *   任意の Request を Router に渡して dispatch される Route が期待値通りである事を確認
         */

        // Routerインスタンス生成
        $router = new \Illuminate\Routing\Router(new Dispatcher());
        $this->assertEquals(0, $router->getRoutes()->count(), 'Router に RouteCollection がセットされていない事を確認');

        // RouteCollection 取得
        // note: \Tests\TestCase の CreatesApplication トレイトで Application が生成される際に、
        //       routes 以下の設定ファイル定義された Route が Route ファサードにセットされる
        $routeCollection = Route::getRoutes();

        // テスト対象となる RouteCollection を Router にセット
        $router->setRoutes($routeCollection);
        $this->assertGreaterThan(1, $router->getRoutes()->count(), 'Router に RouteCollection がセットされた事を確認');

        // Routerインスタンス の protected メソッドの findRoute() にアクセスする為に Reflection
        $reflectionRouter = new \ReflectionClass(get_class($router));
        $findRoute = $reflectionRouter->getMethod('findRoute');
        $findRoute->setAccessible(true);

        // リクエスト生成
        $request = \Illuminate\Http\Request::create('http://localhost:8000/tasks/', 'GET', []);

        // Router に Request を渡し、dispatch された Route を取得
        /** @var \Illuminate\Routing\Route $route */
        $route = $findRoute->invokeArgs($router, [$request]);
        $this->assertEquals(
            TaskIndexController::class,
            $route->getActionName(),
            'リクエストに対応するコントローラが期待値通りである事'
        );
    }
}

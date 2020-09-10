<?php

namespace Tests\Feature\routes;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Task\TaskDestroyController;
use App\Http\Controllers\Task\TaskIndexController;
use App\Http\Controllers\Task\TaskStoreController;
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
         * テスト対象
         *   routes/web.php (=webミドルウェア対象をなる Route の一覧)
         * テスト内容
         *   任意の Request を Router に渡して dispatch される Route が期待値通りである事を確認
         */

        // Laravelアプリケーションインスタンス生成
        $app = new \Illuminate\Foundation\Application(base_path());

        // アプリケーションにHTTPカーネルをバインド
        // ※HTTPカーネルの bootstrap で Router に webミドルウェアグループが適用される
        $app->singleton(
            \Illuminate\Contracts\Http\Kernel::class,
            \App\Http\Kernel::class
        );

        // カーネル生成
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        // カーネルのプロパティからRouterを取得
        // ※protected プロパティにアクセスする為にReflection
        $propRouter = new \ReflectionProperty(get_class($kernel), 'router');
        $propRouter->setAccessible(true);
        /** @var \Illuminate\Routing\Router $router */
        $router = $propRouter->getValue($kernel);

        // protected メソッドの findRoute() にアクセスする為に Reflection
        $reflectionRouter = new \ReflectionClass(get_class($router));
        $findRoute = $reflectionRouter->getMethod('findRoute');
        $findRoute->setAccessible(true);

        // TODO: router/web.php の Route が RouteCollection にセットされるタイミングが把握できてない
        //       => setUp() の時点で既にセットされてる
        // RouteCollection 取得
        $routeCollection = Route::getRoutes();
        // Router の $this->routes を書き換える
        $propRoutes =  $reflectionRouter->getProperty('routes');
        $propRoutes->setAccessible(true);
        $propRoutes->setValue($router, $routeCollection);

        // リクエスト生成
        $request = \Illuminate\Http\Request::create('http://localhost:8000/tasks/', 'GET', []);

        // Router に Request を渡し、dispatch された Route を取得
        /** @var \Illuminate\Routing\Route $route */
        $route = $findRoute->invokeArgs($router, [$request]);
        $this->assertEquals(TaskIndexController::class, $route->getActionName());
    }
}

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


    public function testMap()
    {
        // Laravelアプリケーションインスタンス生成
        $app = new \Illuminate\Foundation\Application('/srv');

        // アプリケーションに App\Http\Kernel をシングルトンとしてバインド
        // App\Http\Kernel は Illuminate\Foundation\Http\Kernel を継承したクラス
        $app->singleton(
            \Illuminate\Contracts\Http\Kernel::class,
            \App\Http\Kernel::class
        );

        // ルーター生成
        $router = new \Illuminate\Routing\Router(new Dispatcher());
        // ルーターにルートを追加
        $router->addRoute('GET', '/', function () {
            return 'hoge';
        });

        $kernel = new \Illuminate\Foundation\Http\Kernel($app, $router);

        $request = \Illuminate\Http\Request::create('http://localhost:8000/', 'GET');


        // protected メソッドをテスト出来るようにする
        $reflection = new \ReflectionClass(\Illuminate\Foundation\Http\Kernel::class);
        $method = $reflection->getMethod('dispatchToRouter');
        $method->setAccessible(true);

        $closure = $method->invokeArgs($kernel, []);
        $response = $closure($request);
        var_dump($response);
    }

}

<?php

namespace Tests\Feature;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Task\TaskDestroyController;
use App\Http\Controllers\Task\TaskIndexController;
use App\Http\Controllers\Task\TaskStoreController;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

final class RouterTest extends TestCase
{
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
}

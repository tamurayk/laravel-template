<?php
declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\Auth\LoginController;
use Tests\AppTestCase;
use Tests\Traits\RoutingTestTrait;

class LoginControllerTest extends AppTestCase
{
    use RoutingTestTrait;

    public function setUp(): void
    {
        parent::setUp();
    }


    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testRouting()
    {
        $this->initAssertRouting();

        $baseUrl = config('app.url');
        $this->assertDispatchedRoute(
            $baseUrl . '/admin/login',
            'GET',
            [
                'actionName' => LoginController::class . '@showLoginForm',
                'routeName' => 'admin.login',
            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl. '/admin/login',
            'POST',
            [
                'actionName' => LoginController::class . '@login',
                'routeName' => '',
            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl . '/admin/logout',
            'POST',
            [
                'actionName' => LoginController::class . '@logout',
                'routeName' => 'admin.logout',
            ]
        );
    }

    public function testMiddleware()
    {
        $this->initAssertRouting();

        $baseUrl = config('app.url');
        $this->assertAppliedMiddleware(
            $baseUrl . '/admin',
            'GET',
            [
                'middleware' => [
                    'admin',
                    'guest:admin',
                ],
            ]
        );
        $this->assertAppliedMiddleware(
            $baseUrl . '/admin/login',
            'POST',
            [
                'middleware' => [
                    'admin',
                    'guest:admin',
                ],
            ]
        );
        $this->assertAppliedMiddleware(
            $baseUrl . '/admin/logout',
            'POST',
            [
                'middleware' => [
                    'admin',
                    'auth:admin',
                ],
            ]
        );
    }
}

<?php
declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers\User\Auth;

use App\Http\Controllers\User\Auth\LoginController;
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
            $baseUrl . '/login',
            'GET',
            [
                'actionName' => LoginController::class . '@showLoginForm',
                'routeName' => 'login',

            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl . '/login',
            'POST',
            [
                'actionName' => LoginController::class . '@login',
                'routeName' => '',
            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl . '/logout',
            'POST',
            [
                'actionName' => LoginController::class . '@logout',
                'routeName' => 'logout',
            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl . '/login/github',
            'GET',
            [
                'actionName' => LoginController::class . '@redirectToProvider',
                'routeName' => 'oauth.login',
            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl . '/login/github/callback',
            'GET',
            [
                'actionName' => LoginController::class . '@handleProviderCallback',
                'routeName' => 'oauth.callback',
            ]
        );
    }

    public function testMiddleware()
    {
        $this->initAssertRouting();

        $baseUrl = config('app.url');
        $this->assertAppliedMiddleware(
            $baseUrl . '/login',
            'GET',
            [
                'web',
            ]
        );
        $this->assertAppliedMiddleware(
            $baseUrl . '/login',
            'POST',
            [
                'web',
            ]
        );
        $this->assertAppliedMiddleware(
            $baseUrl . '/logout',
            'POST',
            [
                'web',
            ]
        );
        $this->assertAppliedMiddleware(
            $baseUrl . '/login/github',
            'GET',
            [
                'web',
                'guest:user',
            ]
        );
        $this->assertAppliedMiddleware(
            $baseUrl . '/login/github/callback',
            'GET',
            [
                'web',
                'guest:user',
            ]
        );
    }
}

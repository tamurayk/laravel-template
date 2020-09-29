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
            $baseUrl. '/login',
            'GET',
            [
                'actionName' => LoginController::class . '@showLoginForm',
                'routeName' => 'login',

            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl. '/login',
            'POST',
            [
                'actionName' => LoginController::class . '@login',
                'routeName' => '',
            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl. '/logout',
            'POST',
            [
                'actionName' => LoginController::class . '@logout',
                'routeName' => 'logout',
            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl. '/login/github',
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

    /**
     * Override to \Tests\Traits\RoutingTestTrait::AppliedMiddlewareTestDataProvider
     * @return array
     */
    public function AppliedMiddlewareTestDataProvider()
    {
        return [
            [
                'login',
                'GET',
                [
                    'web',
                ],
            ],
            [
                'login',
                'POST',
                [
                    'web',
                ],
            ],
            [
                'logout',
                'POST',
                [
                    'web',
                ],
            ],
            [
                'login/{provider}',
                'GET',
                [
                    'web',
                    'guest:user',
                ],
            ],
            [
                'login/{provider}/callback',
                'GET',
                [
                    'web',
                    'guest:user',
                ],
            ],
        ];
    }
}

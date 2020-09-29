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

    /**
     * Override to \Tests\Traits\RoutingTestTrait::RoutingDispatchTestDataProvider
     * @return array
     */
    public function RoutingDispatchTestDataProvider()
    {
        $this->createApplication();
        $baseUrl = config('app.url');

        return [
            [
                $baseUrl. '/login',
                'GET',
                LoginController::class . '@showLoginForm',
                'login',
            ],
            [
                $baseUrl. '/login',
                'POST',
                LoginController::class . '@login',
                '',
            ],
            [
                $baseUrl. '/logout',
                'POST',
                LoginController::class . '@logout',
                'logout',
            ],

            [
                $baseUrl. '/login/github',
                'GET',
                LoginController::class . '@redirectToProvider',
                'oauth.login',
            ],
            [
                $baseUrl. '/login/github/callback',
                'GET',
                LoginController::class . '@handleProviderCallback',
                'oauth.callback',
            ],
        ];
    }
}

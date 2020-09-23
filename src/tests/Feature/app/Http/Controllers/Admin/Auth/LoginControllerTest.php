<?php

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

    /**
     * Override to \Tests\Traits\RoutingTestTrait::RoutingTestDataProvider
     * @return array
     */
    public function RoutingTestDataProvider()
    {
        $this->createApplication();
        $baseUrl = config('app.url');

        return [
            [
                'GET',
                $baseUrl. '/admin/login',
                LoginController::class . '@showLoginForm',
                'admin.login',
            ],
            [
                'POST',
                $baseUrl. '/admin/login',
                LoginController::class . '@login',
                '',
            ],
            [
                'POST',
                $baseUrl. '/admin/logout',
                LoginController::class . '@logout',
                'admin.logout',
            ],
        ];
    }
}

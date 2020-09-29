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
                $baseUrl. '/admin/login',
                'GET',
                LoginController::class . '@showLoginForm',
                'admin.login',
            ],
            [
                $baseUrl. '/admin/login',
                'POST',
                LoginController::class . '@login',
                '',
            ],
            [
                $baseUrl. '/admin/logout',
                'POST',
                LoginController::class . '@logout',
                'admin.logout',
            ],
        ];
    }
}

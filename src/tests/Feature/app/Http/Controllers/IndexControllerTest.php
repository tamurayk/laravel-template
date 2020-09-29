<?php
declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers;

use App\Http\Controllers\IndexController;
use Tests\AppTestCase;
use Tests\Traits\RoutingTestTrait;

class IndexControllerTest extends AppTestCase
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
            $baseUrl. '/',
            'GET',
            [
                'actionName' => IndexController::class,
                'routeName' => 'index',
            ]
        );
    }

    public function testMiddleware()
    {
        $this->initAssertRouting();

        $baseUrl = config('app.url');
        $this->assertAppliedMiddleware(
            $baseUrl. '/',
            'GET',
            [
                'middleware' => [
                    'web',
                ],
            ]
        );
    }
}

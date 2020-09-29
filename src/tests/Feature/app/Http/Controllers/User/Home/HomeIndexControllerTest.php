<?php
declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers\User\Home;

use App\Http\Controllers\User\Home\HomeIndexController;
use Tests\AppTestCase;
use Tests\Traits\RoutingTestTrait;

class HomeIndexControllerTest extends AppTestCase
{
    use RoutingTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->initAssertRouting();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testRouting()
    {
        $baseUrl = config('app.url');
        $this->assertRouting(
            $baseUrl. '/home',
            'GET',
            [
                'actionName' => HomeIndexController::class,
                'routeName' => 'home.index',
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
                'home',
                'GET',
                [
                    'web',
                    'auth:user',
                ],
            ],
        ];
    }
}

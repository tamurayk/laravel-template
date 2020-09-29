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
                'GET',
                $baseUrl. '/home',
                HomeIndexController::class,
                'home.index',
            ],
        ];
    }
}

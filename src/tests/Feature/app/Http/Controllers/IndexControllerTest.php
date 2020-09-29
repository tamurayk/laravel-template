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
                $baseUrl. '/',
                'GET',
                IndexController::class,
                'index',
            ],
        ];
    }
}

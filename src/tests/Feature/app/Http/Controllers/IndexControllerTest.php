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
        $this->assertRouting(
            $baseUrl. '/',
            'GET',
            [
                'actionName' => IndexController::class,
                'routeName' => 'index',
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
                '/',
                'GET',
                [
                    'web',
                ],
            ],
        ];
    }
}

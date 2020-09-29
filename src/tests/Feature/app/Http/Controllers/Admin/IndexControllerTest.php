<?php
declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers\Admin;

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
            $baseUrl. '/admin',
            'GET',
            [
                'actionName' => \App\Http\Controllers\Admin\IndexController::class,
                'routeName' => 'admin.index',

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
                'admin',
                'GET',
                [
                    'admin',
                    'guest:admin',
                ],
            ],
        ];
    }
}

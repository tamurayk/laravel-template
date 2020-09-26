<?php
declare(strict_types=1);

namespace Test\Unit\app\Http\Request\User\Task;

use App\Http\Requests\User\Task\TaskStoreRequest;
use Tests\AppTestCase;
use Tests\Traits\ValidationTestTrait;

class TaskStoreRequestTest extends AppTestCase
{
    use ValidationTestTrait;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Override to \Tests\Traits\ValidationTestTrait::validationTestDataProvider
     * @return array
     */
    public function validationTestDataProvider()
    {
        return [
            '正常' => [
                'formRequest' => new TaskStoreRequest(),
                'formData' => [
                    'name' => str_repeat('a', 10)
                ],
                '$isPass' => true,
                '$expectedMegs' => [],
            ],
            '必須エラー(name)' => [
                'formRequest' => new TaskStoreRequest(),
                'formData' => [
                ],
                '$isPass' => false,
                '$expectedMegs' => [
                    'name' => [
                        'Task Name is required.',
                    ],
                ],
            ],
            '文字数オーバー(name)' => [
                'formRequest' => new TaskStoreRequest(),
                'formData' => [
                    'name' => str_repeat('a', 11)
                ],
                '$isPass' => false,
                '$expectedMegs' => [
                    'name' => [
                        'Task Name may not be greater than 10 characters.',
                    ],
                ],
            ],
        ];
    }
}

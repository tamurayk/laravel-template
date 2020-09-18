<?php
declare(strict_types=1);

namespace Test\Unit\app\Http\UseCase\User\Task;

use App\Http\UseCases\User\Task\TaskIndex;
use App\Models\Eloquents\Task;
use Illuminate\Support\Facades\DB;
use Tests\AppTestCase;

class TaskIndexTest extends AppTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @throws \Exception
     */
    public function testUseCase()
    {
        // Generate test data.
        factory(Task::class, 2)->create([
            'user_id' => 1,
        ]);
        factory(Task::class, 1)->create([
            'user_id' => 2,
        ]);
        $this->assertEquals(3, DB::table('tasks')->count(), 'tasks テーブルにテストデータが 3 件生成されている事');

        // generate UseCase
        $useCase = new TaskIndex(new Task());

        // run UseCase
        $useCaseOutput = $useCase(1);

        // assert
        $this->assertCount(2, $useCaseOutput, 'user_id=1 の task のみを取得している事');
        foreach ($useCaseOutput as $task) {
            $this->assertEquals(1, $task->user_id, 'user_id=1 の task のみを取得している事');
        }

        // run UseCase
        $useCaseOutput = $useCase(2);

        // assert
        $this->assertCount(1, $useCaseOutput, 'user_id=2 の task のみを取得している事');
        foreach ($useCaseOutput as $task) {
            $this->assertEquals(2, $task->user_id, 'user_id=2 の task のみを取得している事');
        }
    }

    /**
     * @test
     */
    public function testPaginator()
    {
        $this->markTestIncomplete('ページネーションに対応したテストを書く');
    }
}

<?php
declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers\User\Task;

use App\Http\Controllers\User\Task\TaskDestroyController;
use App\Models\Eloquents\Task;
use App\Models\Eloquents\User;
use Illuminate\Support\Facades\DB;
use Tests\AppTestCase;
use Tests\Traits\RoutingTestTrait;

class TaskDestroyControllerTest extends AppTestCase
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
            [
                'actionName' => TaskDestroyController::class,
                'routeName' => 'task.destroy',
            ],
            'DELETE',
            $baseUrl. '/task/1'
        );
    }

    public function testMiddleware()
    {
        $this->initAssertRouting();

        $baseUrl = config('app.url');
        $this->assertAppliedMiddleware(
            [
                'middleware' => [
                    'user',
                    'auth:user',
                ],
            ],
            'DELETE',
            $baseUrl. '/task/1'
        );
    }

    /**
     * @test
     */
    public function index_未ログインの場合はログイン画面にリダイレクト()
    {
        // 認証されていない事を確認
        $this->assertGuest(null);

        $response = $this->delete('/task/1');

        // 未認証の場合は、login 画面にリダイレクトする事
        $response->assertStatus(302);
        $response->assertLocation(sprintf('%s/login', config('app.url')));
        $response->assertRedirect(sprintf('%s/login', config('app.url')));
    }

    /**
     * @test
     * @group hoge
     */
    public function index_ログイン中の場合は指定したタスクを削除しタスク一覧にリダイレクト()
    {
        // Generate test data.
        $user = User::factory()->create([
            'id' => 1,
        ]);
        User::factory()->create([
            'id' => 2,
        ]);
        Task::factory()->create([
            'id' => 1,
            'user_id' => 1,
        ]);
        Task::factory()->create([
            'id' => 2,
            'user_id' => 1,
        ]);
        Task::factory()->create([
            'id' => 3,
            'user_id' => 2,
        ]);

        // 認証
        $authUser = $this->actingAs($user, 'user');

        $this->assertEquals(3, DB::table('tasks')->count(), 'HTTPリクエスト前の tasks テーブルのレコード数が 3 件である事を確認');

        // HTTP リクエスト
        $response = $authUser->delete('/task/1');

        // タスク一覧にリダイレクトする事
        $response->assertStatus(302);
        $response->assertLocation(sprintf('%s/tasks', config('app.url')));
        $response->assertRedirect(sprintf('%s/tasks', config('app.url')));


        $this->assertEquals(2, DB::table('tasks')->count(), 'HTTPリクエスト後に 1 レコード削除されている事');
        $this->assertEquals(0, DB::table('tasks')->where('id', 1)->count(), '指定した id のタスクが削除されている事');
    }

    /**
     * @test
     */
    public function index_他人のタスクを削除しようとした場合は403エラーになる事()
    {
        // Generate test data.
        $user = User::factory()->create([
            'id' => 1,
        ]);
        User::factory()->create([
            'id' => 2,
        ]);
        Task::factory()->create([
            'id' => 1,
            'user_id' => 2,
        ]);
        $this->assertEquals(1, DB::table('tasks')->count(), 'HTTPリクエスト前の tasks テーブルのレコード数が 1 件である事を確認');

        // 認証
        $authUser = $this->actingAs($user, 'user');

        // HTTP リクエスト
        $response = $authUser->delete('/task/1');

        // Forbidden エラーになる事
        $response->assertStatus(403);

        $this->assertEquals(1, DB::table('tasks')->count(), 'レコードが削除されていない事');
    }

    /**
     * @test
     */
    public function index_存在しないtask_idを指定した場合は404エラーになる事()
    {
        // 認証
        $user = User::factory()->create([
            'id' => 1,
        ]);
        $authUser = $this->actingAs($user, 'user');

        // HTTP リクエスト
        $response = $authUser->delete('/task/1');

        // Not Found エラーになる事
        $response->assertStatus(404);
    }
}

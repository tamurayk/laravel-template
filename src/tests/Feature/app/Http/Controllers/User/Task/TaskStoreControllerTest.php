<?php
declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers\User\Task;

use App\Http\Controllers\User\Task\TaskStoreController;
use App\Models\Eloquents\User;
use Illuminate\Support\Facades\DB;
use Tests\AppTestCase;
use Tests\Traits\RoutingTestTrait;

class TaskStoreControllerTest extends AppTestCase
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
                'actionName' => TaskStoreController::class,
                'routeName' => 'task.store',
            ],
            'POST',
            $baseUrl. '/task'
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
            'POST',
            $baseUrl. '/task'
        );
    }

    /**
     * @test
     */
    public function index_未ログインの場合はログイン画面にリダイレクト()
    {
        // 認証されていない事を確認
        $this->assertGuest(null);

        $response = $this->post('/task');

        // 未認証の場合は、login 画面にリダイレクトする事
        $response->assertStatus(302);
        $response->assertLocation(sprintf('%s/login', config('app.url')));
        $response->assertRedirect(sprintf('%s/login', config('app.url')));
    }

    /**
     * @test
     */
    public function index_ログイン中の場合はタスクを新規作成しタスク一覧にリダイレクト()
    {
        $this->assertEquals(0, DB::table('tasks')->count(), 'HTTPリクエスト前は tasks テーブルが空である事を確認');

        // 認証
        $user = User::factory()->create([
            'id' => 1,
        ]);
        $authUser = $this->actingAs($user, 'user');

        // HTTP リクエスト
        $data = [
            'name' => 'test'
        ];
        $response = $authUser->post('/task', $data);

        // タスク一覧にリダイレクトする事
        $response->assertStatus(302);
        $response->assertLocation(sprintf('%s/tasks', config('app.url')));
        $response->assertRedirect(sprintf('%s/tasks', config('app.url')));

        // tasks テーブルにレコードが追加される事
        $this->assertEquals(1, DB::table('tasks')->count(), 'HTTPリクエスト後に tasks テーブルに 1 レコード追加されている事');
        $task = DB::table('tasks')->find(1);
        $this->assertEquals(1, $task->user_id, '追加されたレコードの user_id が認証ユーザーの id になっている事');
        $this->assertEquals('test', $task->name, '追加されたレコードの user_id が認証ユーザーの id になっている事');
    }
}
